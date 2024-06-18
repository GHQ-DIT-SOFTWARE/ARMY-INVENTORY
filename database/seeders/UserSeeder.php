<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'Superadmin@admin.com')->first();
        if (is_null($user)) {
            $user = new User();
            $user->name = "Super Admin";
            $user->email = "Superadmin@admin.com";
            $user->status = "1";
            $user->password = Hash::make('admin@123');
            $user->save();
        }
    }
}
