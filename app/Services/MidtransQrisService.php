<?php

namespace App\Services;

use App\Models\Order;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class MidtransQrisService
{
    public function createPayment(Order $order): void
    {
        $serverKey = (string) config('services.midtrans.server_key');
        if ($serverKey === '') {
            throw ValidationException::withMessages([
                'payment_method' => 'Pembayaran QRIS belum dikonfigurasi. Pesanan tidak dapat menampilkan QR.',
            ]);
        }

        $isProduction = (bool) config('services.midtrans.is_production');
        $apiHost = $isProduction ? 'api.midtrans.com' : 'api.sandbox.midtrans.com';
        $orderTime = CarbonImmutable::now();
        $expiresAt = $orderTime->addDay();
        $itemDetails = $order->items->map(fn ($item) => [
            'id' => (string) ($item->product_id ?? $item->id),
            'price' => (int) $item->unit_price,
            'quantity' => (int) $item->quantity,
            'name' => mb_substr($item->product_name, 0, 50),
        ])->values()->all();

        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id' => 'shipping',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos kirim',
            ];
        }

        $payload = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => mb_substr($order->recipient_name, 0, 50),
                'phone' => $order->phone,
            ],
            'qris' => ['acquirer' => 'gopay'],
            'custom_expiry' => [
                'order_time' => $orderTime->timezone('Asia/Jakarta')->format('Y-m-d H:i:s O'),
                'expiry_duration' => 1,
                'unit' => 'day',
            ],
        ];

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->asJson()
                ->timeout(20)
                ->post('https://' . $apiHost . '/v2/charge', $payload);
        } catch (ConnectionException $exception) {
            Log::error('Midtrans QRIS charge failed to connect.', [
                'order_number' => $order->order_number,
                'exception' => $exception->getMessage(),
            ]);

            throw ValidationException::withMessages([
                'payment_method' => 'Tidak dapat terhubung ke Midtrans QRIS. Silakan coba kembali.',
            ]);
        }

        $transactionId = $response->json('transaction_id');
        $qrAction = collect($response->json('actions', []))
            ->firstWhere('name', 'generate-qr-code');
        $qrCodeUrl = is_array($qrAction) ? ($qrAction['url'] ?? null) : null;

        if (
            !$response->successful()
            || !is_string($transactionId)
            || $transactionId === ''
            || !is_string($qrCodeUrl)
            || parse_url($qrCodeUrl, PHP_URL_SCHEME) !== 'https'
            || parse_url($qrCodeUrl, PHP_URL_HOST) !== $apiHost
        ) {
            Log::error('Midtrans did not return a valid QRIS payment code.', [
                'order_number' => $order->order_number,
                'http_status' => $response->status(),
            ]);

            throw ValidationException::withMessages([
                'payment_method' => 'Midtrans belum dapat membuat kode QRIS. Periksa konfigurasi akun lalu coba kembali.',
            ]);
        }

        $order->forceFill([
            'qris_transaction_id' => $transactionId,
            'qris_image_url' => $qrCodeUrl,
            'qris_expires_at' => $expiresAt,
            'payment_status' => 'pending',
        ])->save();
    }

    public function fetchQrImage(Order $order): Response
    {
        $serverKey = (string) config('services.midtrans.server_key');
        $qrCodeUrl = (string) $order->qris_image_url;
        $expectedHost = (bool) config('services.midtrans.is_production')
            ? 'api.midtrans.com'
            : 'api.sandbox.midtrans.com';

        if (
            $serverKey === ''
            || parse_url($qrCodeUrl, PHP_URL_SCHEME) !== 'https'
            || parse_url($qrCodeUrl, PHP_URL_HOST) !== $expectedHost
        ) {
            throw new RuntimeException('Invalid Midtrans QR image configuration.');
        }

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->accept('image/png')
                ->timeout(10)
                ->get($qrCodeUrl);
        } catch (ConnectionException $exception) {
            Log::error('Midtrans QR image request failed.', [
                'order_number' => $order->order_number,
                'exception' => $exception->getMessage(),
            ]);

            throw new RuntimeException('Midtrans QR image is unavailable.', 0, $exception);
        }

        if (!$response->successful() || !str_starts_with((string) $response->header('Content-Type'), 'image/png')) {
            Log::error('Midtrans returned an invalid QR image.', [
                'order_number' => $order->order_number,
                'http_status' => $response->status(),
            ]);

            throw new RuntimeException('Midtrans QR image is unavailable.');
        }

        return $response;
    }
}
