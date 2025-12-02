<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'permissions' => [
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
                ],
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'permissions' => [
                    'view_any_tournament',
                    'view_tournament',
                    'create_tournament',
                    'edit_tournament',
                    'delete_tournament',
                ],
            ],
        ];

        foreach ($roles as $role) {
            $roleModel = \Spatie\Permission\Models\Role::firstOrCreate(
                [
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name']
                ]
            );
            if (isset($role['permissions'])) {
                $roleModel->syncPermissions($role['permissions']);
            }
        }
    }
}
