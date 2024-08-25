<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // name, username, password 
        DB::table('users')->insert([
            'name' => 'Admins',
            'username' => 'admin',
            'password' => Hash::make('123'),
        ]);
    }
}
