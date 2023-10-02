<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'id'         => Str::uuid(),
            'type'       => "superadmin",
            'name'       => 'Super Admin Sistem Pendukung Keputusan',
            'username'   => 'Superadmin',
            'email'      => 'superadmin@payana.com',
            'password'   => Hash::make('register'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // User::where('name', 'Super Admin')->first()->syncRoles('Super Admin');
    }
}
