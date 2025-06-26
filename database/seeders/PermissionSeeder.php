<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'role',
            'user',
            'building',
            'floor',
            'room',
            'responsibility',
            // Yangi model nomini shu yerga qo'shing (masalan: 'user', 'post', ...)
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        $permissions = [];
        foreach ($models as $model) {
            foreach ($actions as $action) {
                $permissions[] = "{$model}.{$action}";
            }
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
