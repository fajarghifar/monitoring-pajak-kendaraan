<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect([
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'created_at' => now()
            ],
            [
                'name' => 'guest',
                'email' => 'guest@quest.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'created_at' => now()
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'created_at' => now()
            ]
        ]);

        $users->each(function ($user){
            User::insert($user);
        });
    }
}