<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Proektor',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="10" width="16" height="6" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="8" cy="13" r="1.5" fill="currentColor"/><path d="M12 16v2m-3 0h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
                'color' => '#7e22ce'
            ],
            [
                'name' => 'Kompyuter',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="5" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><rect x="8" y="19" width="8" height="2" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>',
                'color' => '#2563eb'
            ],
            [
                'name' => 'Printer',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="6" y="3" width="12" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="4" y="9" width="16" height="8" rx="2" stroke="currentColor" stroke-width="1.5"/><rect x="8" y="17" width="8" height="4" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>',
                'color' => '#eab308'
            ],
            [
                'name' => 'Monoblok',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="5" width="16" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><rect x="8" y="17" width="8" height="2" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>',
                'color' => '#0ea5e9'
            ],
            [
                'name' => 'Elektron doska',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="5" width="16" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M12 15v4m-3 0h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
                'color' => '#16a34a'
            ],
            [
                'name' => 'TV',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="5" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M8 21h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
                'color' => '#dc2626'
            ],
            [
                'name' => 'Laptop',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="7" width="16" height="8" rx="2" stroke="currentColor" stroke-width="1.5"/><rect x="2" y="17" width="20" height="2" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>',
                'color' => '#6366f1'
            ],
            [
                'name' => 'Router',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="6" y="12" width="12" height="6" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="15" r="1" fill="currentColor"/><path d="M5 9a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
                'color' => '#ea580c'
            ],
            [
                'name' => 'Kengaytma shnur',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="7" y="9" width="10" height="6" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><path d="M12 15v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
                'color' => '#57534e'
            ],
            [
                'name' => 'Monitor',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="5" width="16" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><rect x="9" y="17" width="6" height="2" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>',
                'color' => '#0e7490'
            ],
        ];

        foreach ($types as $type) {
            EquipmentType::create($type);
        }
    }
}
