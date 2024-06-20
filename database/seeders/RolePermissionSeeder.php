<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        // $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        // $roleAdmin = Role::create(['name' => 'admin']);
        // $roleUser = Role::create(['name' => 'user']);
        $roleSuperAdmin = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'superadmin',
        ]);
        $roleAdmin = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'admin',
        ]);
        $roleUser = Role::create([
            'uuid' => Str::uuid(),
            'name' => 'user',
        ]);

        // Permission List as array
        $permissions = [
            [
                'group_name' => 'superadmin',
                'permissions' => [
                    // superadmin Permissions
                    'superadmin.create',
                    'superadmin.view',
                    'superadmin.edit',
                    'superadmin.delete',
                    'superadmin.approve',
                ],
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ],
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    // user Permissions
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                    'user.approve',
                ],
            ],
        ];
        foreach ($permissions as $permissionGroup) {
            $groupName = $permissionGroup['group_name'];
            foreach ($permissionGroup['permissions'] as $permissionName) {
                $permission = Permission::create([
                    'uuid' => Str::uuid(),
                    'name' => $permissionName,
                    'group_name' => $groupName,
                ]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }
        // Create and Assign Permissions
        // for ($i = 0; $i < count($permissions); $i++) {
        //     $permissionGroup = $permissions[$i]['group_name'];
        //     for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
        //         // Create Permission
        //         $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
        //         $roleSuperAdmin->givePermissionTo($permission);
        //         $permission->assignRole($roleSuperAdmin);
        //     }
        // }
    }
}
