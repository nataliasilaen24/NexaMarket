<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactMessageController extends Controller
{
    private const STATUSES = ['unread', 'read', 'processing', 'done'];

    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'max:10000'],
        ]);

        ContactMessage::create($validated + [
            'user_id' => $request->user()->id,
            'status' => 'unread',
        ]);

        return redirect()->route('contact')->with('success', 'Pesan Anda berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }

    public function adminIndex(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(self::STATUSES)],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';

        $messages = ContactMessage::query()
            ->when($search !== '', function ($query) use ($search) {
                $pattern = '%'.strtolower($search).'%';
                $query->where(function ($messageQuery) use ($pattern) {
                    $messageQuery
                        ->whereRaw('LOWER(name) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(subject) LIKE ?', [$pattern]);
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'unread')->count(),
            'processing' => ContactMessage::where('status', 'processing')->count(),
            'done' => ContactMessage::where('status', 'done')->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'search', 'status', 'summary'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'unread') {
            $contactMessage->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }

        return view('admin.contacts.show', compact('contactMessage'));
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $contactMessage->update([
            'status' => $validated['status'],
            'read_at' => $validated['status'] === 'unread'
                ? null
                : ($contactMessage->read_at ?? now()),
        ]);

        return back()->with('success', 'Status pesan berhasil diperbarui.');
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'reply' => ['required', 'string', 'max:10000'],
        ]);

        $contactMessage->update([
            'admin_reply' => $validated['reply'],
            'status' => 'processing',
            'reply_sent_at' => null,
        ]);

        try {
            Mail::to($contactMessage->email)->send(new ContactReplyMail($contactMessage, $validated['reply']));
        } catch (TransportExceptionInterface $exception) {
            Log::error('Failed to send a NexaMarket contact message reply.', [
                'contact_message_id' => $contactMessage->id,
                'exception' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Balasan tersimpan, tetapi email belum berhasil dikirim. Periksa konfigurasi email lalu coba lagi.');
        }

        $contactMessage->update([
            'status' => 'done',
            'reply_sent_at' => now(),
        ]);

        return redirect()
            ->route('admin.contacts.show', $contactMessage)
            ->with('success', 'Balasan berhasil dikirim ke email pelanggan.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
