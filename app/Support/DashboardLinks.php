<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\User;

class DashboardLinks
{
    public static function forGlobal(User $user): array
    {
        return self::filter([
            ['route' => 'weapons.issues.create', 'label' => 'Initiate Issue Request', 'icon' => 'feather icon-send', 'variant' => 'primary', 'can' => 'weapons.issue'],
            ['route' => 'viewpurchase', 'label' => 'Log Restock', 'icon' => 'feather icon-truck', 'variant' => 'outline-primary', 'can' => 'weapons.manage'],
            ['route' => 'view-item', 'label' => 'Manage Inventory', 'icon' => 'feather icon-package', 'variant' => 'outline-secondary', 'can' => 'weapons.manage'],
            ['route' => 'audit.trail', 'label' => 'Review Audit Trail', 'icon' => 'feather icon-activity', 'variant' => 'outline-secondary', 'can' => null],
        ], $user);
    }

    public static function forWeapons(User $user): array
    {
        return self::filter([
            ['route' => 'weapons.dashboard', 'label' => 'Weapons Overview', 'icon' => 'feather icon-target', 'variant' => 'primary', 'can' => 'weapons.view'],
            ['route' => 'weapons.categories.index', 'label' => 'Manage Categories', 'icon' => 'feather icon-layers', 'variant' => 'outline-primary', 'can' => 'weapons.manage'],
            ['route' => 'weapons.armories.index', 'label' => 'Armory Register', 'icon' => 'feather icon-home', 'variant' => 'outline-primary', 'can' => 'armories.manage'],
            ['route' => 'weapons.platforms.index', 'label' => 'Weapon Library', 'icon' => 'feather icon-book', 'variant' => 'outline-secondary', 'can' => 'weapons.manage'],
            ['route' => 'weapons.inventory.index', 'label' => 'Tracked Inventory', 'icon' => 'feather icon-database', 'variant' => 'outline-secondary', 'can' => 'weapons.manage'],
            ['route' => 'weapons.issues.create', 'label' => 'Issue Weapons', 'icon' => 'feather icon-send', 'variant' => 'outline-primary', 'can' => 'weapons.issue'],
            ['route' => 'weapons.returns.form', 'label' => 'Return Weapons', 'icon' => 'feather icon-log-in', 'variant' => 'outline-secondary', 'can' => 'weapons.return'],
            ['route' => 'weapons.issues.track', 'label' => 'Track Weapon', 'icon' => 'feather icon-search', 'variant' => 'outline-secondary', 'can' => 'weapons.return'],
        ], $user);
    }

    public static function forVehicles(User $user): array
    {
        return self::filter([
            ['route' => 'vehicles.dashboard', 'label' => 'Vehicles Overview', 'icon' => 'feather icon-truck', 'variant' => 'success', 'can' => 'vehicles.view'],
            ['route' => 'vehicles.categories.index', 'label' => 'Vehicle Categories', 'icon' => 'feather icon-layers', 'variant' => 'outline-success', 'can' => 'vehicles.manage'],
            ['route' => 'vehicles.motor-pools.index', 'label' => 'Motor Pools', 'icon' => 'feather icon-map', 'variant' => 'outline-success', 'can' => 'vehicles.manage'],
            ['route' => 'vehicles.platforms.index', 'label' => 'Vehicle Library', 'icon' => 'feather icon-book', 'variant' => 'outline-secondary', 'can' => 'vehicles.manage'],
            ['route' => 'vehicles.inventory.index', 'label' => 'Vehicle Inventory', 'icon' => 'feather icon-database', 'variant' => 'outline-secondary', 'can' => 'vehicles.manage'],
            ['route' => 'vehicles.deployments.create', 'label' => 'Deploy Vehicles', 'icon' => 'feather icon-send', 'variant' => 'outline-success', 'can' => 'vehicles.deploy'],
            ['route' => 'vehicles.returns.form', 'label' => 'Return Vehicles', 'icon' => 'feather icon-log-in', 'variant' => 'outline-secondary', 'can' => 'vehicles.return'],
            ['route' => 'vehicles.deployments.track', 'label' => 'Track Asset', 'icon' => 'feather icon-search', 'variant' => 'outline-secondary', 'can' => 'vehicles.return'],
        ], $user);
    }

    public static function forAdministration(User $user): array
    {
        return self::filter([
            ['route' => 'index-roles', 'label' => 'Role Directory', 'icon' => 'feather icon-briefcase', 'variant' => 'outline-dark', 'can' => 'roles.manage'],
            ['route' => 'create-roles', 'label' => 'Create Role', 'icon' => 'feather icon-plus-circle', 'variant' => 'outline-dark', 'can' => 'roles.manage'],
            ['route' => 'index-user', 'label' => 'User Accounts', 'icon' => 'feather icon-users', 'variant' => 'outline-dark', 'can' => 'users.manage-domain'],
            ['route' => 'create-user', 'label' => 'Add User', 'icon' => 'feather icon-user-plus', 'variant' => 'outline-dark', 'can' => 'users.manage-domain'],
            ['route' => 'audit.trail', 'label' => 'Audit Trail', 'icon' => 'feather icon-activity', 'variant' => 'outline-dark', 'can' => null],
        ], $user);
    }

    public static function merged(User $user): array
    {
        $links = array_merge(
            self::forGlobal($user),
            self::forWeapons($user),
            self::forVehicles($user),
            self::forAdministration($user)
        );

        $seen = [];

        return array_values(array_filter($links, function (array $link) use (&$seen) {
            if (in_array($link['route'], $seen, true)) {
                return false;
            }
            $seen[] = $link['route'];

            return true;
        }));
    }

    private static function filter(array $links, User $user): array
    {
        return array_values(array_filter($links, function (array $link) use ($user) {
            $ability = $link['can'] ?? null;

            return empty($ability) || $user->can($ability);
        }));
    }
}
