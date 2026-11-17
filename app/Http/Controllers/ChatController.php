<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'after_id' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'before_id' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'mark_read' => ['sometimes', 'boolean'],
        ]);
        $conversation = ChatConversation::where('user_id', $request->user()->id)->first();

        if ($conversation === null) {
            return response()->json([
                'messages' => [],
                'admin_online' => $this->adminIsOnline(),
            ]);
        }

        if ($request->boolean('mark_read')) {
            $conversation->messages()
                ->where('sender_role', 'admin')
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        $messagesQuery = $conversation->messages();
        $hasMore = null;
        if (array_key_exists('after_id', $validated) && $validated['after_id'] !== null) {
            $messagesQuery->where('id', '>', $validated['after_id'])->orderBy('id');
        } else {
            if (array_key_exists('before_id', $validated) && $validated['before_id'] !== null) {
                $messagesQuery->where('id', '<', $validated['before_id']);
            }

            $messages = $messagesQuery->orderByDesc('id')->limit(51)->get();
            $hasMore = $messages->count() > 50;
            $messages = $messages->take(50)->reverse()->values();
        }

        if ($hasMore === null) {
            $messages = $messagesQuery->limit(100)->get();
        }

        $response = [
            'messages' => $messages->map(fn (ChatMessage $message) => $this->serializeMessage($message)),
            'admin_online' => $this->adminIsOnline(),
        ];
        if ($hasMore !== null) {
            $response['has_more'] = $hasMore;
        }

        return response()->json($response);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);
        $conversation = ChatConversation::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);
        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'sender_role' => 'user',
            'body' => $validated['body'],
        ]);
        $conversation->update(['last_message_at' => $message->created_at]);

        return response()->json([
            'message' => $this->serializeMessage($message),
        ], 201);
    }

    private function adminIsOnline(): bool
    {
        return User::where('is_admin', true)
            ->where('chat_last_seen_at', '>=', now()->subMinutes(2))
            ->exists();
    }

    private function serializeMessage(ChatMessage $message): array
    {
        return [
            'id' => $message->id,
            'sender_role' => $message->sender_role,
            'body' => $message->body,
            'sent_at' => $message->created_at?->toIso8601String(),
            'read_at' => $message->read_at?->toIso8601String(),
        ];
    }
}
