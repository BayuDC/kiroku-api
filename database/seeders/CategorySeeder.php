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
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
