<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily to avoid issues with existing data
        // if this seeder is run multiple times or in a specific order.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data in the 'countries' table to prevent duplicate entries
        // if the seeder is run multiple times.
        DB::table('roles')->truncate();

        $roles = [
            'admin',
            'content-manager',
            'instructor',
            'user',
            'guest',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
