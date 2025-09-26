<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the roles table to avoid duplicates
        DB::table('roles')->truncate();

        // Define roles with their respective guards
        $roles = [
            ['name' => 'admin', 'guard_name' => 'admin'],
            ['name' => 'content-manager', 'guard_name' => 'content-manager'],
            ['name' => 'instructor', 'guard_name' => 'instructor'],
            ['name' => 'user', 'guard_name' => 'web'],
            ['name' => 'guest', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']]
            );
        }
    }
}
