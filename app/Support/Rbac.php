<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Rbac
{
    public const ROLE_SUPER_ADMIN = 'super-admin';

    public const PERMISSION_USERS_MANAGE_ALL = 'users.manage-all';
    public const PERMISSION_USERS_MANAGE_DOMAIN = 'users.manage-domain';

    public const CACHE_KEY_PERMISSION_GROUPS = 'rbac.permission_groups';
    public const CACHE_KEY_ROLE_PERMISSIONS = 'rbac.role_permissions';

    public static function permissionGroups(): array
    {
        return Cache::rememberForever(self::CACHE_KEY_PERMISSION_GROUPS, function (): array {
            return [
                'weapons' => [
                    'weapons.view',
                    'weapons.manage',
                    'weapons.issue',
                    'weapons.return',
                ],
                'vehicles' => [
                    'vehicles.view',
                    'vehicles.manage',
                    'vehicles.delete',
                    'vehicles.deploy',
                    'vehicles.return',
                ],
                'armories' => [
                    'armories.view',
                    'armories.manage',
                ],
                'users' => [
                    self::PERMISSION_USERS_MANAGE_DOMAIN,
                    self::PERMISSION_USERS_MANAGE_ALL,
                ],
                'roles' => [
                    'roles.manage',
                ],
                'reports' => [
                    'reports.view',
                ],
            ];
        });
    }

    public static function rolePermissions(): array
    {
        return Cache::rememberForever(self::CACHE_KEY_ROLE_PERMISSIONS, function (): array {
            return [
                self::ROLE_SUPER_ADMIN => ['*'],
                'weapons-ops' => [
                    'weapons.view',
                    'weapons.manage',
                    'weapons.issue',
                    'weapons.return',
                    'armories.view',
                ],
                'vehicle-ops' => [
                    'vehicles.view',
                    'vehicles.manage',
                    'vehicles.delete',
                    'vehicles.deploy',
                    'vehicles.return',
                ],
            ];
        });
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY_PERMISSION_GROUPS);
        Cache::forget(self::CACHE_KEY_ROLE_PERMISSIONS);
    }

    public static function ensureRolesAndPermissions(): void
    {
        self::clearCache();

        $permissions = collect(self::permissionGroups())
            ->flatMap(fn (array $names) => $names)
            ->unique();

        $permissions->each(function (string $name): void {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        });

        foreach (self::rolePermissions() as $roleName => $permissionNames) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            if ($permissionNames === ['*']) {
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions($permissionNames);
            }
        }
    }

    public static function manageableRoleNames(?object $user): array
    {
        if (! $user) {
            return [];
        }

        if ($user->can(self::PERMISSION_USERS_MANAGE_ALL)) {
            return Role::pluck('name')->all();
        }

        return Role::where('name', '!=', self::ROLE_SUPER_ADMIN)
            ->pluck('name')
            ->all();
    }

    public static function allRoles(): Collection
    {
        return Role::orderBy('name')->get();
    }

    public static function canManageUsers(?object $user): bool
    {
        return $user ? $user->can(self::PERMISSION_USERS_MANAGE_DOMAIN) || $user->can(self::PERMISSION_USERS_MANAGE_ALL) : false;
    }
}

