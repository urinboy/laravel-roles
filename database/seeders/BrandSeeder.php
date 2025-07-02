<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'HP',
                'description' => 'HP (Hewlett-Packard) — xalqaro texnologik kompaniya, kompyuter va printerlar ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/hp.png',
                'is_active' => true,
            ],
            [
                'name' => 'Dell',
                'description' => 'Dell — kompyuterlar va aksessuarlar ishlab chiqaradigan mashhur kompaniya.',
                'logo' => '/assets/logos/dell.png',
                'is_active' => true,
            ],
            [
                'name' => 'Lenovo',
                'description' => 'Lenovo — yirik global kompyuter va noutbuk ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/lenovo.png',
                'is_active' => true,
            ],
            [
                'name' => 'Acer',
                'description' => 'Acer — Tayvanda joylashgan kompyuter texnikasi va elektronika ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/acer.png',
                'is_active' => true,
            ],
            [
                'name' => 'Asus',
                'description' => 'ASUS — Tayvanlik kompyuter, telefon va elektronika mahsulotlari ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/asus.png',
                'is_active' => true,
            ],
            [
                'name' => 'Apple',
                'description' => 'Apple — AQShning nufuzli texnologik kompaniyasi, Mac, iPhone va boshqa qurilmalar ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/apple.png',
                'is_active' => true,
            ],
            [
                'name' => 'Samsung',
                'description' => 'Samsung — Janubiy Koreya elektronika va texnika yetakchi ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/samsung.png',
                'is_active' => true,
            ],
            [
                'name' => 'Canon',
                'description' => 'Canon — Yaponiyaning optik va suratga olish texnikasi ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/canon.png',
                'is_active' => true,
            ],
            [
                'name' => 'Epson',
                'description' => 'Epson — Yaponiyada joylashgan printer va boshqa ofis texnikasi ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/epson.png',
                'is_active' => true,
            ],
            [
                'name' => 'LG',
                'description' => 'LG — Janubiy Koreya kompaniyasi, elektronika va maishiy texnika ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/lg.png',
                'is_active' => true,
            ],
            [
                'name' => 'Sony',
                'description' => 'Sony — Yaponiyaning mashhur elektronika, televizor va audio mahsulotlari ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/sony.png',
                'is_active' => true,
            ],
            [
                'name' => 'BenQ',
                'description' => 'BenQ — Tayvanlik kompaniya, monitor va proyektor ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/benq.png',
                'is_active' => true,
            ],
            [
                'name' => 'MSI',
                'description' => 'MSI — Tayvanlik kompaniya, kompyuter va noutbuk komponentlari ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/msi.png',
                'is_active' => true,
            ],
            [
                'name' => 'TP-Link',
                'description' => 'TP-Link — Xitoylik ishlab chiqaruvchi, router va tarmoq uskunalari yetkazib beruvchisi.',
                'logo' => '/assets/logos/tplink.png',
                'is_active' => true,
            ],
            [
                'name' => 'Xiaomi',
                'description' => 'Xiaomi — Xitoyning mashhur smartfon va texnika ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/xiaomi.png',
                'is_active' => true,
            ],
            [
                'name' => 'Huawei',
                'description' => 'Huawei — Xitoyning yirik telekommunikatsiya va elektronika ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/huawei.png',
                'is_active' => true,
            ],
            [
                'name' => 'MyPRO',
                'description' => 'MyPRO — Oʻzbekistonda ishlab chiqarilgan zamonaviy texnika brendi.',
                'logo' => '/assets/logos/mypro.png',
                'is_active' => true,
            ],
            [
                'name' => 'Artel',
                'description' => 'Artel — Oʻzbekistonda faoliyat yurituvchi maishiy texnika va elektronika mahsulotlari ishlab chiqaruvchisi.',
                'logo' => '/assets/logos/artel.png',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
