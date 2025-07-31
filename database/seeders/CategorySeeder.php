<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $categories = [
            'Alat Ukur Elektronik',
            'Komponen Elektronik',
            'Peralatan Solder',
            'Alat Bantu Praktikum',
            'Bahan Habis Pakai',
            'Peralatan Jaringan',
            'Microcontroller & Development Board',
            'Peralatan Audio Video',
            'Komponen Mekanik',
            'Peralatan Keselamatan Kerja',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
