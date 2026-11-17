<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminChatController extends Controller
{
    public function index(Request $request)
    {
        $this->updatePresence($request->user());
        $validated = $request->validate([
            'filter' => ['nullable', Rule::in(['all', 'unanswered'])],
        ]);
        $filter = $validated['filter'] ?? 'all';
        $conversations = $this->conversationQuery($filter)->get();

        return view('admin.chats.index', compact('conversations', 'filter'));
    }

    public function conversations(Request $request): JsonResponse
    {
        $this->updatePresence($request->user());
        $validated = $request->validate([
            'filter' => ['nullable', Rule::in(['all', 'unanswered'])],
        ]);

        return response()->json([
            'conversations' => $this->conversationQuery($validated['filter'] ?? 'all')
                ->get()
                ->map(fn (ChatConversation $conversation) => $this->serializeConversation($conversation)),
        ]);
    }

    public function messages(Request $request, ChatConversation $conversation): JsonResponse
    {
        $this->updatePresence($request->user());
        $validated = $request->validate([
            'after_id' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'before_id' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'mark_read' => ['sometimes', 'boolean'],
        ]);

        if ($request->boolean('mark_read')) {
            $conversation->messages()
                ->where('sender_role', 'user')
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
        ];
        if ($hasMore !== null) {
            $response['has_more'] = $hasMore;
        }

        return response()->json($response);
    }

    public function store(Request $request, ChatConversation $conversation): JsonResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);
        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'sender_role' => 'admin',
            'body' => $validated['body'],
        ]);
        $conversation->update(['last_message_at' => $message->created_at]);
        $this->updatePresence($request->user());

        return response()->json([
            'message' => $this->serializeMessage($message),
        ], 201);
    }

    private function conversationQuery(string $filter): Builder
    {
        return ChatConversation::query()
            ->with(['user', 'latestMessage'])
            ->withCount([
                'messages as unread_count' => fn (Builder $query) => $query
                    ->where('sender_role', 'user')
                    ->whereNull('read_at'),
            ])
            ->when(
                $filter === 'unanswered',
                fn (Builder $query) => $query->whereHas(
                    'latestMessage',
                    fn (Builder $messageQuery) => $messageQuery->where('sender_role', 'user')
                )
            )
            ->orderByDesc('last_message_at')
            ->orderByDesc('id');
    }

    private function updatePresence(User $admin): void
    {
        if ($admin->chat_last_seen_at === null || $admin->chat_last_seen_at->lt(now()->subSeconds(30))) {
            User::whereKey($admin->id)->update(['chat_last_seen_at' => now()]);
            $admin->chat_last_seen_at = now();
        }
    }

    private function serializeConversation(ChatConversation $conversation): array
    {
        return [
            'id' => $conversation->id,
            'customer_name' => $conversation->user->name,
            'customer_email' => $conversation->user->email,
            'latest_body' => $conversation->latestMessage?->body,
            'latest_sender_role' => $conversation->latestMessage?->sender_role,
            'latest_sent_at' => $conversation->latestMessage?->created_at?->toIso8601String(),
            'unread_count' => (int) $conversation->unread_count,
        ];
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
