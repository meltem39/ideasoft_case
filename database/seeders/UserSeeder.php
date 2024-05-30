<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        date_default_timezone_set('Etc/GMT-3');

        $users = [
            [
                'name' => 'Meltem Özkan',
                'email' => 'meltem@ozkanmeltem.com',
                'password' => bcrypt("password"),
                'since' => Carbon::now()->format("Y-m-d")
            ],
            [
                'name' => 'Meltem Özkan',
                'email' => 'info@ideasoft.com',
                'password' => bcrypt("password"),
                'since' => Carbon::now()->format("Y-m-d")

            ]
        ];

        foreach ($users as $user) {
            User::insert($user);
        }
    }
}
