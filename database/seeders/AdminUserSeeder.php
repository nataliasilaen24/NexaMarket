<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use InvalidArgumentException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = (string) config('admin.email');
        $password = (string) config('admin.password');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            throw new InvalidArgumentException(
                'Set ADMIN_EMAIL yang valid dan isi ADMIN_PASSWORD sebelum menjalankan AdminUserSeeder.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => (string) config('admin.name'),
                'password' => $password,
                'is_admin' => true,
            ]
        );
    }
}
