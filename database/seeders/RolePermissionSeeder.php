<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Support\Rbac;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionGroups = Rbac::permissionGroups();

        foreach ($permissionGroups as $group => $permissionNames) {
            foreach ($permissionNames as $permissionName) {
                $permission = Permission::firstOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'web'],
                    ['uuid' => (string) Str::uuid(), 'group_name' => $group]
                );

                $this->touchPermission($permission, $group);
            }
        }

        $allPermissionNames = Permission::pluck('name')->all();

        foreach (Rbac::rolePermissions() as $roleName => $permissionNames) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web'],
                ['uuid' => (string) Str::uuid()]
            );

            if (empty($role->uuid)) {
                $role->uuid = (string) Str::uuid();
                $role->save();
            }

            if ($permissionNames === ['*']) {
                $role->syncPermissions($allPermissionNames);
            } else {
                $role->syncPermissions($permissionNames);
            }
        }

        app('cache')
            ->store(config('permission.cache.store') !== 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    private function touchPermission(Permission $permission, string $group): void
    {
        $dirty = false;

        if (empty($permission->uuid)) {
            $permission->uuid = (string) Str::uuid();
            $dirty = true;
        }

        if ($permission->group_name !== $group) {
            $permission->group_name = $group;
            $dirty = true;
        }

        if ($permission->guard_name !== 'web') {
            $permission->guard_name = 'web';
            $dirty = true;
        }

        if ($dirty) {
            $permission->save();
        }
    }
}
