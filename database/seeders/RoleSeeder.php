<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
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
            'admin',
            'user'
        ];

        foreach ($roles as $role) { 
            Role::create([
                'name' => $role
            ]);
        }

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => bcrypt('12345')
        ]);

        $user_id = User::first();
        $role_id = Role::where('name', 'admin')->first();

        UserRole::create([
            'user_id' => $user_id->id,
            'role_id' => $role_id->id
        ]);
    }
}
