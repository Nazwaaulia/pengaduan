<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin keren',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('apalu'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Petugas keren',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('apasih'),
            'role' => 'petugas'
        ]);
    }
}
