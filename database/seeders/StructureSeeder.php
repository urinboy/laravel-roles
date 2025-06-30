<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\ResponsiblePerson;
use App\Models\Room; // Room modelini import qilishni unutmang!
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Ma'lumotlar bazasini to'ldirish (seed) jarayonini ishga tushirish.
     */
    public function run(): void
    {
        // Responsible people
        // Mas'ul shaxslar yaratish.
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

        // Building 1: Main Building
        // 1-bino: Bosh bino yaratish.
        $building1 = Building::create([
            'name' => 'Bosh bino',
            'description' => 'Markaziy administrativ bino',
            'address' => 'Toshkent sh., Mustaqillik ko\'chasi, 1',
            'is_active' => true,
        ]);

        // Floor 1 in Building 1
        // 1-binodagi 1-qavatni yaratish.
        $floor1_1 = $building1->floors()->create([
            'floor_number' => 1,
            'description' => 'Birinchi qavat',
            'level' => 1,
            'is_active' => true,
        ]);

        // Rooms on Floor 1_1
        // 1-qavatdagi xonalarni yaratish va ularga mas'ul shaxslarni biriktirish.
        // E'tibor bering: 'responsible_person_id' o'rniga 'responsiblePeople()->attach()' ishlatiladi.

        // Room 101: Direktor xonasi
        $room101 = $floor1_1->rooms()->create([
            'number' => '101',
            'name' => 'Direktor xonasi',
            'description' => 'Direktor qabulxonasi',
            'is_active' => true,
        ]);
        // Attach responsible person(s) to Room 101
        // 101-xonaga mas'ul shaxslarni biriktirish (Ali Valiyev).
        $room101->responsiblePeople()->attach($person1->id);

        // Room 102: Buxgalteriya
        $room102 = $floor1_1->rooms()->create([
            'number' => '102',
            'name' => 'Buxgalteriya',
            'description' => 'Buxgalteriya xonasi',
            'is_active' => true,
        ]);
        // Attach responsible person(s) to Room 102 (Hasan Husanov)
        // 102-xonaga mas'ul shaxslarni biriktirish (Hasan Husanov).
        $room102->responsiblePeople()->attach($person2->id);
        // Let's add Ali Valiyev to Buxgalteriya as well (example of multiple people for one room)
        // Bitta xonaga bir nechta mas'ul shaxs biriktirishga misol: Ali Valiyevni ham Buxgalteriyaga qo'shamiz.
        $room102->responsiblePeople()->attach($person1->id);


        // Floor 2 in Building 1
        // 1-binodagi 2-qavatni yaratish.
        $floor1_2 = $building1->floors()->create([
            'floor_number' => 2,
            'description' => 'Ikkinchi qavat',
            'level' => 2,
            'is_active' => true,
        ]);

        // Room 201: Kadrlar bo'limi
        $room201 = $floor1_2->rooms()->create([
            'number' => '201',
            'name' => 'Kadrlar bo\'limi',
            'description' => 'Kadrlar bo\'limi xonasi',
            'is_active' => true,
        ]);
        // Attach responsible person(s) to Room 201 (Hasan Husanov)
        // 201-xonaga mas'ul shaxslarni biriktirish (Hasan Husanov).
        $room201->responsiblePeople()->attach($person2->id);


        // Building 2: Education Building
        // 2-bino: O'quv binosini yaratish.
        $building2 = Building::create([
            'name' => 'O\'quv binosi',
            'description' => 'Talabalar uchun ma\'ruza xonalari',
            'address' => 'Toshkent sh., Amir Temur ko\'chasi, 100',
            'is_active' => true,
        ]);

        // Floor 1 in Building 2
        // 2-binodagi 1-qavatni yaratish.
        $floor2_1 = $building2->floors()->create([
            'floor_number' => 1,
            'description' => 'Birinchi qavat',
            'level' => 1,
            'is_active' => true,
        ]);

        // Room 1: 1-auditoriya
        $room202 = $floor2_1->rooms()->create([
            'number' => '1',
            'name' => '1-auditoriya',
            'description' => 'Katta ma\'ruzalar zali',
            'is_active' => true,
        ]);
        // Attach responsible person(s) to Room 1 (Salim Salimov)
        // 1-auditoriyaga mas'ul shaxslarni biriktirish (Salim Salimov).
        $room202->responsiblePeople()->attach($person3->id);
    }
}
