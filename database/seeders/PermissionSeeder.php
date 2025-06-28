<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'role',
            'permission',
            'user',
            'contract',
            'building',
            'floor',
            'room',
            'responsibility',
            // Add new model names here, e.g., 'post'
        ];

        $actions = ['list', 'view', 'create', 'edit', 'delete'];

        $permissions = [];
        foreach ($models as $model) {
            foreach ($actions as $action) {
                $permissions[] = "{$model}.{$action}";
            }
        }

        // 1. Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create or get the admin role
        $adminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // 3. Assign all permissions to admin role
        $adminRole->syncPermissions(Permission::all());

        // 4. Create or get the admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'urinboydev@gmail.com'],
            [
                'name' => 'urinboydev',
                'first_name' => 'Urinboy',
                'last_name' => 'Tursunboev',
                'phone' => '+998970961196',
                'password' => bcrypt('12344321'), // Choose a stronger password in production!
            ]
        );

        // 5. Assign admin role to admin user
        $adminUser->assignRole($adminRole);

        // 6. Create or get the user role (ordinary user)
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // 7. (Optional) Assign limited permissions to the user role
        // For example, only list/view for buildings, floors, rooms, etc.
        $userRolePermissions = Permission::where(function($query) {
            $query->where('name', 'like', 'building.list')
                  ->orWhere('name', 'like', 'building.view')
                  ->orWhere('name', 'like', 'floor.list')
                  ->orWhere('name', 'like', 'floor.view')
                  ->orWhere('name', 'like', 'room.list')
                  ->orWhere('name', 'like', 'room.view')
                  ->orWhere('name', 'like', 'responsibility.list')
                  ->orWhere('name', 'like', 'responsibility.view');
        })->get();

        $userRole->syncPermissions($userRolePermissions);

        // 8. Create or get an ordinary user
        $ordinaryUser = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'user',
                'first_name' => 'Oddiy',
                'last_name' => 'Foydalanuvchi',
                'phone' => '+998901234567',
                'password' => bcrypt('user'), // Choose a stronger password in production!
            ]
        );

        // 9. Assign user role to ordinary user
        $ordinaryUser->assignRole($userRole);
    }
}
