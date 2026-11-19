<?php

namespace Tests\Feature;

use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_shows_configured_contact_details_and_location_map(): void
    {
        config([
            'contact.address' => 'Jl. Contoh 10, Bandung',
            'contact.whatsapp' => '0812 3456 7890',
            'contact.email' => 'halo@nexamarket.example',
            'contact.hours' => 'Senin–Jumat, 09.00–17.00',
            'contact.instagram' => 'https://instagram.com/nexamarket',
            'contact.facebook' => 'https://facebook.com/nexamarket',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->get(route('contact'));

        $response->assertOk()
            ->assertSee('Hubungi Kami')
            ->assertSee('Jl. Contoh 10, Bandung')
            ->assertSee('0812 3456 7890')
            ->assertSee('href="https://wa.me/6281234567890"', false)
            ->assertSee('halo@nexamarket.example')
            ->assertSee('Senin–Jumat, 09.00–17.00')
            ->assertSee('href="https://instagram.com/nexamarket"', false)
            ->assertSee('href="https://facebook.com/nexamarket"', false)
            ->assertSee('maps.google.com/maps?q=Jl.+Contoh+10%2C+Bandung&amp;output=embed', false);
    }

    public function test_customer_can_submit_a_contact_message_and_admin_can_manage_it(): void
    {
        Mail::fake();
        $customer = User::factory()->create(['name' => 'Nadia Pelanggan', 'email' => 'nadia@example.test']);
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($customer);

        $this->post(route('contact.store'), [
            'name' => 'Nadia Pelanggan',
            'email' => 'nadia@example.test',
            'subject' => 'Pertanyaan pesanan',
            'body' => "Mohon bantu cek pesanan saya.\nTerima kasih.",
        ])->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $message = ContactMessage::firstOrFail();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'user_id' => $customer->id,
            'status' => 'unread',
        ]);

        $this->actingAs($admin);
        $this->get(route('admin.contacts.index', ['search' => 'Pertanyaan']))
            ->assertOk()
            ->assertSee('Nadia Pelanggan')
            ->assertSee('nadia@example.test')
            ->assertSee('Belum Dibaca')
            ->assertDontSee(route('admin.categories.index'), false)
            ->assertSee('admin-sidebar-link is-active', false)
            ->assertSee(route('admin.contacts.show', $message), false);

        $this->get(route('admin.contacts.show', $message))
            ->assertOk()
            ->assertSee('Mohon bantu cek pesanan saya.')
            ->assertSee('Kontak')
            ->assertSee('Balas Pesan');

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'status' => 'read',
        ]);

        $this->patch(route('admin.contacts.status.update', $message), [
            'status' => 'processing',
        ])->assertRedirect()
            ->assertSessionHas('success');

        $this->get(route('admin.contacts.index', ['status' => 'processing']))
            ->assertOk()
            ->assertSee('Pertanyaan pesanan');
        $this->get(route('admin.contacts.index', ['status' => 'unread']))
            ->assertOk()
            ->assertDontSee('Pertanyaan pesanan');

        $this->post(route('admin.contacts.reply', $message), [
            'reply' => 'Pesanan Anda sedang kami periksa.',
        ])->assertRedirect(route('admin.contacts.show', $message))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'status' => 'done',
            'admin_reply' => 'Pesanan Anda sedang kami periksa.',
        ]);
        Mail::assertSent(ContactReplyMail::class, fn (ContactReplyMail $mail) => $mail->hasTo('nadia@example.test'));

        $this->delete(route('admin.contacts.destroy', $message))
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_contacts_navigation_is_admin_only(): void
    {
        $message = ContactMessage::create([
            'name' => 'Nadia Pelanggan',
            'email' => 'nadia@example.test',
            'subject' => 'Pertanyaan',
            'body' => 'Isi pesan.',
        ]);

        $this->get(route('admin.contacts.index'))->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.contacts.index'))->assertForbidden();
        $this->get(route('admin.contacts.show', $message))->assertForbidden();
        $this->delete(route('admin.contacts.destroy', $message))->assertForbidden();
    }
}
