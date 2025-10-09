<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Support\Rbac;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmins = [
            [
                'email' => 'Superadmin@admin.com',
                'name' => 'Super Admin',
            ],
            [
                'email' => 'sule.aktious@gmail.com',
                'name' => 'Sule Aktious',
            ],
        ];

        foreach ($superAdmins as $admin) {
            $user = User::firstOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'status' => '1',
                    'password' => Hash::make('22Secured@1'),
                ]
            );

            if (! $user->hasRole(Rbac::ROLE_SUPER_ADMIN)) {
                $user->syncRoles([Rbac::ROLE_SUPER_ADMIN]);
            }
        }
    }
}
