<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\ResponsiblePerson;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mas'ul shaxslar
        $person1 = ResponsiblePerson::create([
            'full_name' => 'Ali Valiyev',
            'phone' => '+998901234567',
            'is_active' => true,
        ]);

        $person2 = ResponsiblePerson::create([
            'full_name' => 'Hasan Husanov',
            'phone' => '+998912345678',
            'is_active' => true,
        ]);

        $person3 = ResponsiblePerson::create([
            'full_name' => 'Salim Salimov',
            'phone' => '+998934567890',
            'is_active' => false,
        ]);

        // 1-bino: Bosh bino
        $building1 = Building::create([
            'name' => 'Bosh bino',
            'description' => 'Markaziy administrativ bino',
            'address' => 'Toshkent sh., Mustaqillik ko\'chasi, 1',
            'is_active' => true,
        ]);

        // 1-binodagi 1-qavat
        $floor1_1 = $building1->floors()->create([
            'floor_number' => 1,
            'description' => 'Birinchi qavat',
            'level' => 1,
            'is_active' => true,
        ]);

        // 1-qavatdagi xonalar
        $floor1_1->rooms()->create([
            'number' => '101',
            'name' => 'Direktor xonasi',
            'description' => 'Direktor qabulxonasi',
            'is_active' => true,
            'responsible_person_id' => $person1->id,
        ]);

        $floor1_1->rooms()->create([
            'number' => '102',
            'name' => 'Buxgalteriya',
            'description' => 'Buxgalteriya xonasi',
            'is_active' => true,
            'responsible_person_id' => $person2->id,
        ]);

        // 1-binodagi 2-qavat
        $floor1_2 = $building1->floors()->create([
            'floor_number' => 2,
            'description' => 'Ikkinchi qavat',
            'level' => 2,
            'is_active' => true,
        ]);

        // 2-qavatdagi xona
        $floor1_2->rooms()->create([
            'number' => '201',
            'name' => 'Kadrlar bo\'limi',
            'description' => 'Kadrlar bo\'limi xonasi',
            'is_active' => true,
            'responsible_person_id' => $person2->id,
        ]);

        // 2-bino: O'quv binosi
        $building2 = Building::create([
            'name' => 'O\'quv binosi',
            'description' => 'Talabalar uchun ma\'ruza xonalari',
            'address' => 'Toshkent sh., Amir Temur ko\'chasi, 100',
            'is_active' => true,
        ]);

        // 2-binodagi 1-qavat
        $floor2_1 = $building2->floors()->create([
            'floor_number' => 1,
            'description' => 'Birinchi qavat',
            'level' => 1,
            'is_active' => true,
        ]);

        // 1-qavatdagi xona
        $floor2_1->rooms()->create([
            'number' => '1',
            'name' => '1-auditoriya',
            'description' => 'Katta ma\'ruzalar zali',
            'is_active' => true,
            'responsible_person_id' => $person3->id,
        ]);
    }
}
