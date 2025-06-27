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
            'building',
            'floor',
            'room',
            'responsibility',
            // Yangi model nomini shu yerga qo'shing (masalan: 'post', ...)
        ];

        $actions = ['list', 'view', 'create', 'edit', 'delete'];

        $permissions = [];
        foreach ($models as $model) {
            foreach ($actions as $action) {
                $permissions[] = "{$model}.{$action}";
            }
        }

        // 1. Ruxsatlarni yaratish
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Admin rolini yaratish yoki olish
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 3. Barcha permissionlarni admin roliga biriktirish
        $adminRole->syncPermissions(Permission::all());

        // 4. Admin user yaratish yoki olish
        $adminUser = User::firstOrCreate(
            ['email' => 'urinboydev@gmail.com'],
            [
                'name' => 'Urinboy Dev',
                'password' => bcrypt('12344321'), // Kuchliroq parol tanlang!
            ]
        );

        // 5. Admin userga admin rolini biriktirish
        $adminUser->assignRole($adminRole);
    }
}
