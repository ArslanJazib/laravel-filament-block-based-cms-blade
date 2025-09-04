<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();

        $users = [
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'phone' => '1234567890',
                'security_questions' => [
                    ['question' => 'Your first school?', 'answer' => 'Alpha School']
                ],
                'company_name' => 'AdminCorp',
                'job_title' => 'Platform Admin',
                'country_id' => 1,
                'role' => 'admin',
            ],
            [
                'name' => 'Content Manager',
                'username' => 'contentmanager',
                'email' => 'content@example.com',
                'password' => Hash::make('password'),
                'phone' => '1112223333',
                'security_questions' => [
                    ['question' => 'Favorite color?', 'answer' => 'Blue']
                ],
                'company_name' => 'Contentify',
                'job_title' => 'Content Strategist',
                'country_id' => 1,
                'role' => 'content-manager',
            ],
            [
                'name' => 'Instructor User',
                'username' => 'instructor',
                'email' => 'instructor@example.com',
                'password' => Hash::make('password'),
                'phone' => '4445556666',
                'security_questions' => [
                    ['question' => 'Birth city?', 'answer' => 'Lahore']
                ],
                'company_name' => 'LearnPro',
                'job_title' => 'Lead Instructor',
                'country_id' => 1,
                'role' => 'instructor',
            ],
            [
                'name' => 'Standard User',
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'phone' => '7778889999',
                'security_questions' => [
                    ['question' => 'Favorite food?', 'answer' => 'Pizza']
                ],
                'company_name' => null,
                'job_title' => null,
                'country_id' => 1,
                'role' => 'user',
            ],
            [
                'name' => 'Guest User',
                'username' => 'guest',
                'email' => 'guest@example.com',
                'password' => Hash::make('password'),
                'phone' => '0001112222',
                'security_questions' => [
                    ['question' => 'Favorite movie?', 'answer' => 'Inception']
                ],
                'company_name' => null,
                'job_title' => null,
                'country_id' => 1,
                'role' => 'guest',
            ],
        ];

        foreach ($users as $data) {
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone' => $data['phone'],
                'security_questions' => json_encode($data['security_questions']),
                'company_name' => $data['company_name'],
                'job_title' => $data['job_title'],
                'country_id' => $data['country_id'],
            ]);

            $user->assignRole($data['role']);
        }
    }
}