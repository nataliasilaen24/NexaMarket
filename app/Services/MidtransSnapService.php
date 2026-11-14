<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class MidtransSnapService
{
    public function fetchTransactionStatus(string $orderNumber): array
    {
        $serverKey = (string) config('services.midtrans.server_key');
        $isProduction = (bool) config('services.midtrans.is_production');
        $baseUrl = $isProduction
            ? 'https://api.midtrans.com'
            : 'https://api.sandbox.midtrans.com';

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->timeout(5)
                ->get($baseUrl . '/v2/' . rawurlencode($orderNumber) . '/status');
        } catch (ConnectionException $exception) {
            Log::error('Midtrans status verification failed.', [
                'order_number' => $orderNumber,
                'exception' => $exception->getMessage(),
            ]);

            throw new RuntimeException('Midtrans status verification is unavailable.', 0, $exception);
        }

        $status = $response->json();
        if (!$response->successful() || !is_array($status)) {
            Log::error('Midtrans returned an invalid transaction status response.', [
                'order_number' => $orderNumber,
                'http_status' => $response->status(),
            ]);

            throw new RuntimeException('Midtrans status verification is unavailable.');
        }

        return $status;
    }

    public function createPayment(Order $order): string
    {
        $serverKey = (string) config('services.midtrans.server_key');
        if ($serverKey === '') {
            throw ValidationException::withMessages([
                'payment_method' => 'Pembayaran online belum dikonfigurasi. Silakan pilih COD atau hubungi pengelola toko.',
            ]);
        }

        $isProduction = (bool) config('services.midtrans.is_production');
        $baseUrl = $isProduction
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
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
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => mb_substr($order->recipient_name, 0, 50),
                'phone' => $order->phone,
            ],
            'enabled_payments' => [
                $order->payment_method === 'qris' ? 'qris' : 'credit_card',
            ],
            'credit_card' => ['secure' => true],
            'callbacks' => [
                'finish' => route('checkout.confirmation', $order->order_number),
            ],
        ];

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->asJson()
                ->timeout(20)
                ->post($baseUrl . '/snap/v1/transactions', $payload);
        } catch (ConnectionException $exception) {
            Log::error('Midtrans Snap connection failed.', [
                'order_number' => $order->order_number,
                'exception' => $exception->getMessage(),
            ]);

            throw ValidationException::withMessages([
                'payment_method' => 'Tidak dapat terhubung ke Midtrans. Silakan coba kembali atau pilih COD.',
            ]);
        }

        $redirectUrl = $response->json('redirect_url');
        if (!$response->successful() || !is_string($redirectUrl) || $redirectUrl === '') {
            Log::error('Midtrans Snap did not return a payment URL.', [
                'order_number' => $order->order_number,
                'http_status' => $response->status(),
            ]);

            throw ValidationException::withMessages([
                'payment_method' => 'Midtrans belum dapat membuat pembayaran. Periksa konfigurasi akun lalu coba kembali.',
            ]);
        }

        $order->forceFill([
            'snap_redirect_url' => $redirectUrl,
            'payment_status' => 'pending',
        ])->save();

        return $redirectUrl;
    }
}
