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
            'name' => "Dev Admin",
            'email' => 'admin@admin.com',
            'password' => bcrypt('qwer1234'),
        ]);
    }
}
