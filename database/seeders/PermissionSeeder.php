<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_any_user',
            'view_user',
            'create_user',
            'edit_user',
            'delete_user',
            'view_any_tournament',
            'view_tournament',
            'create_tournament',
            'edit_tournament',
            'delete_tournament',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
