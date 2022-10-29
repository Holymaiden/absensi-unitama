<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nik' => 'admin',
            'nama_staf' => 'admin',
            'jabatan' => 'operator',
            'jurusan' => 'operator',
            'golongan' => 'operator',
            'notelp' => '123',
            'password' => Hash::make('admin'),
            'role_id' => 1,
            'active' => 1,
        ]);
        DB::table('roles')->insert(
            [
                'role' => 'A',
                'role_name' => 'admin',
            ],
            [
                'role' => 'U',
                'role_name' => 'user',
            ]
        );
    }
}
