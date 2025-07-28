<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tools = [
            [
                'name' => 'Multimeter Digital Fluke 179',
                'category_id' => 1, // Alat Ukur Elektronik
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Multimeter digital untuk mengukur tegangan, arus, dan resistansi. Akurasi tinggi dengan display LCD.',
            ],
            [
                'name' => 'Oscilloscope Tektronix TDS2012C',
                'category_id' => 1, // Alat Ukur Elektronik
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Oscilloscope digital 2 channel untuk analisis sinyal. Bandwidth 100MHz dengan sampling rate 1GS/s.',
            ],
            [
                'name' => 'Function Generator RIGOL DG1032Z',
                'category_id' => 1, // Alat Ukur Elektronik
                'status' => 'borrowed',
                'condition' => 'good',
                'description' => 'Generator sinyal 2 channel dengan frekuensi hingga 30MHz. Dilengkapi dengan arbitrary waveform.',
            ],
            [
                'name' => 'Solder Station Hakko FX-888D',
                'category_id' => 3, // Peralatan Solder
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Solder station digital dengan kontrol suhu presisi. Dilengkapi dengan berbagai jenis mata solder.',
            ],
            [
                'name' => 'Power Supply DC Adjustable 0-30V 5A',
                'category_id' => 4, // Alat Bantu Praktikum
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Power supply DC variabel dengan output 0-30V dan arus maksimal 5A. Dilengkapi dengan proteksi arus lebih.',
            ],
        ];

        foreach ($tools as $tool) {
            Tool::create($tool);
        }
    }
}
