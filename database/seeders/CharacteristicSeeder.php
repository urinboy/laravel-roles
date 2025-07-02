<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use App\Models\EquipmentValue;
use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacteristicSeeder extends Seeder
{
    public function run(): void
    {
        // Uskuna turlari mavjudligini tekshirish yoki yaratish
        $computer = EquipmentType::firstOrCreate(['name' => 'Компьютер']);

        // Xususiyatlarni qo'shish
        $properties = [
            ['name' => 'Процессор (CPU)', 'equipment_type_id' => $computer->id],
            ['name' => 'Биоэкран', 'equipment_type_id' => $computer->id],
            ['name' => 'ОЗУ (RAM)', 'equipment_type_id' => $computer->id],
            ['name' => 'HDD', 'equipment_type_id' => $computer->id],
        ];

        foreach ($properties as $property) {
            Property::firstOrCreate(
                ['name' => $property['name'], 'equipment_type_id' => $property['equipment_type_id']],
                $property
            );
        }

        // Xususiyat qiymatlarini qo'shish
        $values = [
            ['property_name' => 'Процессор (CPU)', 'value' => 'Intel Core i5-8400'],
            ['property_name' => 'Биоэкран', 'value' => 'NVIDIA GTX 1050 Ti'],
            ['property_name' => 'ОЗУ (RAM)', 'value' => '8 GB'],
            ['property_name' => 'HDD', 'value' => '256 GB'],
            ['property_name' => 'HDD', 'value' => '256 GB'],
            ['property_name' => 'HDD', 'value' => '256 GB'],
        ];

        foreach ($values as $value) {
            $property = Property::where('name', $value['property_name'])->where('equipment_type_id', $computer->id)->first();
            if ($property) {
                EquipmentValue::firstOrCreate(
                    ['property_id' => $property->id, 'value' => $value['value']],
                    ['property_id' => $property->id, 'value' => $value['value']]
                );
            }
        }

        // // Uskuna turlari mavjudligini tekshirish yoki yaratish
        // $projector = EquipmentType::firstOrCreate(['name' => 'Проектор']);
        // $computer = EquipmentType::firstOrCreate(['name' => 'Компьютер']);
        // $printer = EquipmentType::firstOrCreate(['name' => 'Принтер']);

        // // Xususiyatlarni qo'shish
        // $characteristics = [
        //     ['name' => 'Наименование', 'equipment_type_id' => $projector->id],
        //     ['name' => 'Модель', 'equipment_type_id' => $projector->id],
        //     ['name' => 'Серийный номер', 'equipment_type_id' => $projector->id],
        //     ['name' => 'Наименование', 'equipment_type_id' => $computer->id],
        //     ['name' => 'Процессор', 'equipment_type_id' => $computer->id],
        //     ['name' => 'Оперативная память', 'equipment_type_id' => $computer->id],
        //     ['name' => 'Наименование', 'equipment_type_id' => $printer->id],
        //     ['name' => 'Тип принтера', 'equipment_type_id' => $printer->id],
        //     ['name' => 'Разрешение', 'equipment_type_id' => $printer->id],
        // ];

        // foreach ($characteristics as $characteristic) {
        //     Property::firstOrCreate(
        //         ['name' => $characteristic['name'], 'equipment_type_id' => $characteristic['equipment_type_id']],
        //         $characteristic
        //     );
        // }
    }
}
