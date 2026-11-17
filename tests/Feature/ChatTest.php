<?php

namespace Tests\Feature;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_send_messages_and_receive_admin_replies(): void
    {
        $customer = User::factory()->create(['name' => 'Pelanggan Chat']);
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($customer)
            ->postJson(route('chat.store'), ['body' => 'Apakah produk tersedia?'])
            ->assertCreated()
            ->assertJsonPath('message.sender_role', 'user')
            ->assertJsonPath('message.body', 'Apakah produk tersedia?');

        $conversation = ChatConversation::where('user_id', $customer->id)->firstOrFail();
        $this->assertDatabaseHas('chat_messages', [
            'chat_conversation_id' => $conversation->id,
            'sender_id' => $customer->id,
            'sender_role' => 'user',
            'body' => 'Apakah produk tersedia?',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.chats.index'))
            ->assertOk()
            ->assertSee('Pelanggan Chat')
            ->assertSee('Apakah produk tersedia?');

        $this->postJson(route('admin.chats.store', $conversation), [
            'body' => 'Ya, produk masih tersedia.',
        ])->assertCreated()
            ->assertJsonPath('message.sender_role', 'admin');

        $this->getJson(route('admin.chats.messages', [
            'conversation' => $conversation,
            'mark_read' => 1,
        ]))->assertOk()
            ->assertJsonFragment(['body' => 'Ya, produk masih tersedia.']);

        $this->assertNotNull(
            ChatMessage::where('chat_conversation_id', $conversation->id)
                ->where('sender_role', 'user')
                ->firstOrFail()
                ->read_at
        );

        $this->actingAs($customer)
            ->getJson(route('chat.messages', ['after_id' => 1]))
            ->assertOk()
            ->assertJsonFragment(['body' => 'Ya, produk masih tersedia.']);
    }

    public function test_customers_cannot_read_other_customers_chat_and_admin_routes_are_protected(): void
    {
        $customer = User::factory()->create();
        $otherCustomer = User::factory()->create();

        $this->actingAs($customer)
            ->postJson(route('chat.store'), ['body' => 'Pesan privat'])
            ->assertCreated();

        $this->actingAs($otherCustomer)
            ->getJson(route('chat.messages'))
            ->assertOk()
            ->assertExactJson([
                'messages' => [],
                'admin_online' => false,
            ]);

        $this->get(route('admin.chats.index'))->assertForbidden();

        auth()->logout();
        $this->get(route('admin.chats.index'))->assertRedirect(route('login'));
    }

    public function test_chat_messages_are_validated(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)
            ->postJson(route('chat.store'), ['body' => ''])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('body');

        $this->assertDatabaseCount('chat_conversations', 0);
        $this->assertDatabaseCount('chat_messages', 0);
    }

    public function test_customer_can_page_back_through_older_chat_messages(): void
    {
        $customer = User::factory()->create();
        $conversation = ChatConversation::create(['user_id' => $customer->id]);

        foreach (range(1, 52) as $number) {
            $conversation->messages()->create([
                'sender_id' => $customer->id,
                'sender_role' => 'user',
                'body' => 'Pesan '.$number,
            ]);
        }

        $latestPage = $this->actingAs($customer)
            ->getJson(route('chat.messages'))
            ->assertOk()
            ->assertJsonCount(50, 'messages')
            ->assertJsonPath('has_more', true);
        $oldestVisibleId = $latestPage->json('messages.0.id');

        $this->getJson(route('chat.messages', ['before_id' => $oldestVisibleId]))
            ->assertOk()
            ->assertJsonCount(2, 'messages')
            ->assertJsonPath('has_more', false)
            ->assertJsonFragment(['body' => 'Pesan 1'])
            ->assertJsonFragment(['body' => 'Pesan 2']);
    }
}
