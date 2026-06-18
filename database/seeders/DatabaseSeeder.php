<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@magerwa.rw'],
            [
                'name'        => 'Admin Magerwa',
                'phone'       => '+250788000000',
                'national_id' => '1199880012345678',
                'password'    => Hash::make('password123'),
            ]
        );
    }
}
