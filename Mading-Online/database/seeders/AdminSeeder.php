<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::insert([
            [
                'id_admin' => 1,
                'nama'     => 'admin-fr',
                'email'    => 'fr_12119481@gmail.com',
                'password' => Hash::make('123'), // MD5 '123' was 202cb962ac59075b964b07152d234b70
            ],
            [
                'id_admin' => 2,
                'nama'     => 'brian',
                'email'    => 'brian.kang@gmail.com',
                'password' => Hash::make('123'),
            ],
        ]);
    }
}
