<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Meltem Özkan',
                'email' => 'meltem@ozkanmeltem.com',
                'password' => bcrypt("password"),
            ],
            [
                'name' => 'Meltem Özkan',
                'email' => 'info@ideasoft.com',
                'password' => bcrypt("password"),
            ]
        ];

        foreach ($users as $user) {
            User::insert($user);
        }
    }
}