<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'fullname' => 'Administrator',
            'email' => 'admin@scanreach.com',
            'password' => Hash::make('password'),
            'status' => 'active'
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'fullname' => 'Taufik',
            'email' => 'taufikridho505@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'active'
        ]);
    }
}
