<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Superadmin'],
            ['id' => 2, 'name' => 'Admin'],
            ['id' => 3, 'name' => 'Technician']
        ]);

        DB::table('resources')->insert([
            ['id' => 1, 'name' => 'user'],
            ['id' => 2, 'name' => 'permission'],
            ['id' => 3, 'name' => 'technician'],
            ['id' => 4, 'name' => 'region'],
            ['id' => 5, 'name' => 'activity'],
            ['id' => 6, 'name' => 'request-status'],
            ['id' => 7, 'name' => 'device-status'],
            ['id' => 8, 'name' => 'device-type'],
            ['id' => 9, 'name' => 'device-detail'],
            ['id' => 10, 'name' => 'device'],
            ['id' => 11, 'name' => 'taxpayer'],
            ['id' => 12, 'name' => 'visitation'],
            ['id' => 13, 'name' => 'visitation-image']
        ]);

        DB::table('users')->insert([
            'id' => 1, // Menggunakan ID tetap
            'role_id' => 1, // Superadmin Role ID
            'name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => '$2y$12$6reWw1hX9IYC58u73ibGjuLYc0ijQSVXx8UvQBoZRJMGVOEgf/2ie', // Password sudah di-hash
            'remember_token' => \Illuminate\Support\Str::random(60),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('permissions')->insert(
            [
                ['id' => 1, 'user_id' => 1, 'resource_id' => 1, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'user_id' => 1, 'resource_id' => 2, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'user_id' => 1, 'resource_id' => 3, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'user_id' => 1, 'resource_id' => 4, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 5, 'user_id' => 1, 'resource_id' => 5, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 6, 'user_id' => 1, 'resource_id' => 6, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 7, 'user_id' => 1, 'resource_id' => 7, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 8, 'user_id' => 1, 'resource_id' => 5, 'role_id' => 3, 'can_view_any' => 0, 'can_create' => 0, 'can_edit' => 0, 'can_delete' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 9, 'user_id' => 1, 'resource_id' => 8, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 10, 'user_id' => 1, 'resource_id' => 9, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 11, 'user_id' => 1, 'resource_id' => 10, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 12, 'user_id' => 1, 'resource_id' => 11, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 13, 'user_id' => 1, 'resource_id' => 12, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1,  'created_at' => now(),'updated_at' => now()],
                ['id' => 14, 'user_id' => 1, 'resource_id' => 13, 'role_id' => 1, 'can_view_any' => 1, 'can_create' => 1, 'can_edit' => 1, 'can_delete' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]
        );
    }
}