<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['user' => 'Siswa Test', 'email' => 'siswa@example.com', 'role' => 'siswa'],
            ['user' => 'Guru Test',  'email' => 'guru@example.com',  'role' => 'guru'],
            ['user' => 'Osis Test',  'email' => 'osis@example.com',  'role' => 'osis'],
            ['user' => 'Admin Test', 'email' => 'admin@example.com', 'role' => 'admin'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'user' => $user['user'],
                    'role' => $user['role'],
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
