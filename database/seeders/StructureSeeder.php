<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\ResponsiblePerson;
use App\Models\Floor;
use App\Models\Room;
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

        // Bino 1
        $building1 = Building::create([
            'name' => 'Bosh bino',
            'description' => 'Markaziy administrativ bino',
            'address' => "Toshkent sh., Mustaqillik ko'chasi, 1",
            'is_active' => true,
        ]);

        // 1-qavat (Bino 1)
        $floor1_1 = Floor::create([
            'building_id' => $building1->id,
            'floor_number' => 1,
            'description' => 'Birinchi qavat',
            'level' => 1,
            'is_active' => true,
        ]);
        // Xonalar (1-qavat)
        $room101 = Room::create([
            'floor_id' => $floor1_1->id,
            'number' => '101',
            'name' => 'Direktor xonasi',
            'description' => 'Direktor qabulxonasi',
            'is_active' => true,
        ]);
        $room101->responsiblePeople()->attach($person1->id);

        $room102 = Room::create([
            'floor_id' => $floor1_1->id,
            'number' => '102',
            'name' => 'Buxgalteriya',
            'description' => 'Buxgalteriya xonasi',
            'is_active' => true,
        ]);
        $room102->responsiblePeople()->attach([$person2->id, $person1->id]);

        // 2-qavat (Bino 1)
        $floor1_2 = Floor::create([
            'building_id' => $building1->id,
            'floor_number' => 2,
            'description' => 'Ikkinchi qavat',
            'level' => 2,
            'is_active' => true,
        ]);
        $room201 = Room::create([
            'floor_id' => $floor1_2->id,
            'number' => '201',
            'name' => "Kadrlar bo'limi",
            'description' => "Kadrlar bo'limi xonasi",
            'is_active' => true,
        ]);
        $room201->responsiblePeople()->attach($person2->id);

        // Bino 2
        $building2 = Building::create([
            'name' => "O'quv binosi",
            'description' => "Talabalar uchun ma'ruza xonalari",
            'address' => "Toshkent sh., Amir Temur ko'chasi, 100",
            'is_active' => true,
        ]);

        // 1-qavat (Bino 2)
        $floor2_1 = Floor::create([
            'building_id' => $building2->id,
            'floor_number' => 1,
            'description' => 'Birinchi qavat',
            'level' => 1,
            'is_active' => true,
        ]);
        $room1 = Room::create([
            'floor_id' => $floor2_1->id,
            'number' => '1',
            'name' => '1-auditoriya',
            'description' => "Katta ma'ruzalar zali",
            'is_active' => true,
        ]);
        $room1->responsiblePeople()->attach($person3->id);
    }
}
