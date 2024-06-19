<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_users')->insert([
            'name' => "Dev Root Admin",
            'email' => 'admin@root.com',
            'password' => bcrypt('qwer1234'),
            'role' => 'root',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}
