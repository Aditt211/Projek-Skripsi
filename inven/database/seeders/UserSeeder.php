<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Admin Perhotelan',
            'email' => 'adminph@mail.com',
            'password' => Hash::make('adminph'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Admin Tata Boga',
            'email' => 'admintbo@mail.com',
            'password' => Hash::make('admintbo'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Admin Tata Busana',
            'email' => 'admintbu@mail.com',
            'password' => Hash::make('admintbu'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Admin Manajemen Perkantoran',
            'email' => 'adminmp@mail.com',
            'password' => Hash::make('adminmp'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Admin Desain Komunikasi Visual',
            'email' => 'admindkv@mail.com',
            'password' => Hash::make('admindkv'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
