<?php

namespace Database\Seeders;

use App\Models\Consumable;
use Illuminate\Database\Seeder;

class ConsumableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $consumables = [
            [
                'name' => 'Resistor 1kΩ 1/4W',
                'category_id' => 2, // Komponen Elektronik
                'stock' => 500,
                'description' => 'Resistor karbon film 1kΩ dengan toleransi 5% dan daya 1/4 watt. Warna: coklat-hitam-merah-emas.',
            ],
            [
                'name' => 'Kapasitor Elektrolit 100µF 25V',
                'category_id' => 2, // Komponen Elektronik
                'stock' => 200,
                'description' => 'Kapasitor elektrolit 100µF tegangan kerja 25V. Polaritas positif dan negatif harus diperhatikan.',
            ],
            [
                'name' => 'LED 5mm Merah',
                'category_id' => 2, // Komponen Elektronik
                'stock' => 300,
                'description' => 'LED 5mm warna merah dengan tegangan forward 2V dan arus maksimal 20mA. Sudut pancaran 30 derajat.',
            ],
            [
                'name' => 'Timah Solder 60/40 0.8mm',
                'category_id' => 5, // Bahan Habis Pakai
                'stock' => 10,
                'description' => 'Timah solder dengan komposisi 60% timah dan 40% timbal. Diameter 0.8mm dengan flux rosin core.',
            ],
            [
                'name' => 'Breadboard 830 Tie Points',
                'category_id' => 4, // Alat Bantu Praktikum
                'stock' => 50,
                'description' => 'Breadboard untuk prototyping dengan 830 tie points. Ukuran standar dengan binding posts untuk power supply.',
            ],
        ];

        foreach ($consumables as $consumable) {
            Consumable::create($consumable);
        }
    }
}
