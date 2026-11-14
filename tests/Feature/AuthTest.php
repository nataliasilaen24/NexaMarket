<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_must_register_or_sign_in_before_opening_the_store(): void
    {
        $this->get(route('login'))->assertOk();
        $this->get(route('register'))->assertOk();
        $this->get(route('home'))->assertRedirect(route('login'));
        $this->get(route('profile.edit'))->assertRedirect(route('login'));
        $this->get(route('shop'))->assertRedirect(route('login'));
        $this->get(route('promotions.index'))->assertRedirect(route('login'));
        $this->get(route('cart.index'))->assertRedirect(route('login'));
        $this->postJson(route('payment.midtrans.notification'), [])
            ->assertForbidden();
    }

    public function test_registration_creates_a_customer_account_and_ignores_public_admin_role_input(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Ayu Silaen',
            'email' => 'ayu@example.test',
            'password' => '123',
            'password_confirmation' => '123',
            'is_admin' => true,
        ])->assertRedirect(route('home'));

        $user = User::where('email', 'ayu@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertFalse($user->is_admin);
        $this->assertTrue(Hash::check('123', $user->password));

        $this->get(route('profile'))
            ->assertOk()
            ->assertSee('Profil Saya')
            ->assertSee('Anggota NexaMarket')
            ->assertSee('ayu@example.test')
            ->assertSee(route('profile.edit'))
            ->assertDontSee('name="password"', false);

        $this->get(route('profile.edit'))
            ->assertOk()
            ->assertSee('Ubah Profil')
            ->assertSee('name="password"', false);
    }

    public function test_admin_account_uses_the_shared_login_and_can_access_promo_management(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('profile'))
            ->assertOk()
            ->assertSee('Admin')
            ->assertSee('Kelola Promo');
        $this->get(route('admin.products.index'))->assertOk();
    }

    public function test_admin_seeder_accepts_a_short_password(): void
    {
        config([
            'admin.name' => 'Admin',
            'admin.email' => 'admin@example.test',
            'admin.password' => '7',
        ]);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'admin@example.test')->firstOrFail();
        $this->assertTrue($admin->is_admin);
        $this->assertTrue(Hash::check('7', $admin->password));
    }

    public function test_profile_can_be_updated_and_user_can_log_out(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'baru@example.test',
            'password' => 'a',
            'password_confirmation' => 'a',
        ])->assertRedirect(route('profile'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'baru@example.test',
        ]);
        $this->assertTrue(Hash::check('a', $user->fresh()->password));

        $this->post(route('logout'))
            ->assertRedirect(route('login'));
        $this->assertGuest();
        $this->get(route('home'))->assertRedirect(route('login'));
    }
}
