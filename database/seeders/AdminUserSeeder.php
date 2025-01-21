<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat Role Admin jika belum ada
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Membuat User dan menetapkan Role Admin
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Jangan lupa untuk hash password
        ]);

        // Menetapkan Role Admin pada User
        $user->assignRole($role);
    }
}
