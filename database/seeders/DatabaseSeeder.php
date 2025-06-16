<?php

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);

        // Ganti nama dan email dengan milik kamu
        User::factory()->create([
            'name' => 'Inggar Kinanthi Sandong Guritno', // Ganti sesuai nama lengkap kamu
            'email' => 'inggar@example.com',             // Ganti dengan email kamu
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ]);

        // Data dummy
        User::factory(100)->create();
        Category::factory(200)->create();
        Todo::factory(500)->create();
    }
}

