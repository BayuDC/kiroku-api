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
            // Alat Ukur Elektronik (Category 1)
            [
                'name' => 'Multimeter Digital Fluke 179',
                'category_id' => 1,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Multimeter digital untuk mengukur tegangan, arus, dan resistansi. Akurasi tinggi dengan display LCD.',
            ],
            [
                'name' => 'Oscilloscope Tektronix TDS2012C',
                'category_id' => 1,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Oscilloscope digital 2 channel untuk analisis sinyal. Bandwidth 100MHz dengan sampling rate 1GS/s.',
            ],
            [
                'name' => 'Function Generator RIGOL DG1032Z',
                'category_id' => 1,
                'status' => 'borrowed',
                'condition' => 'good',
                'description' => 'Generator sinyal 2 channel dengan frekuensi hingga 30MHz. Dilengkapi dengan arbitrary waveform.',
            ],
            [
                'name' => 'LCR Meter Keysight E4980A',
                'category_id' => 1,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'LCR meter presisi untuk mengukur induktansi, kapasitansi, dan resistansi komponen elektronik.',
            ],
            [
                'name' => 'Spectrum Analyzer Rohde & Schwarz FSW',
                'category_id' => 1,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Spectrum analyzer untuk analisis spektrum frekuensi sinyal RF hingga 26.5 GHz.',
            ],
            [
                'name' => 'Network Analyzer Keysight E5071C',
                'category_id' => 1,
                'status' => 'borrowed',
                'condition' => 'good',
                'description' => 'Network analyzer untuk karakterisasi rangkaian RF dan microwave.',
            ],
            [
                'name' => 'Clamp Meter Fluke 376 FC',
                'category_id' => 1,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Tang ampere digital dengan konektivitas wireless untuk pengukuran arus AC/DC.',
            ],
            [
                'name' => 'Digital Storage Oscilloscope Siglent SDS1104X-E',
                'category_id' => 1,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'DSO 4 channel dengan bandwidth 100MHz dan sampling rate 1GSa/s.',
            ],

            // Komponen Elektronik (Category 2) - Tools for handling components
            [
                'name' => 'Component Tester DER EE DE-5000',
                'category_id' => 2,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Automatic component tester untuk identifikasi dan pengukuran komponen elektronik.',
            ],
            [
                'name' => 'IC Puller Set',
                'category_id' => 2,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Set alat untuk mencabut IC dari socket tanpa merusak kaki IC.',
            ],

            // Peralatan Solder (Category 3)
            [
                'name' => 'Solder Station Hakko FX-888D',
                'category_id' => 3,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Solder station digital dengan kontrol suhu presisi. Dilengkapi dengan berbagai jenis mata solder.',
            ],
            [
                'name' => 'SMD Rework Station Aoyue 968A+',
                'category_id' => 3,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Hot air rework station untuk pekerjaan SMD dengan kontrol suhu dan aliran udara.',
            ],
            [
                'name' => 'Desoldering Pump Goot TP-100',
                'category_id' => 3,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Solder sucker manual untuk membersihkan solder dari PCB.',
            ],
            [
                'name' => 'Soldering Iron Weller WES51',
                'category_id' => 3,
                'status' => 'borrowed',
                'condition' => 'good',
                'description' => 'Soldering iron analog dengan kontrol suhu dan display digital.',
            ],

            // Alat Bantu Praktikum (Category 4)
            [
                'name' => 'Power Supply DC Adjustable 0-30V 5A',
                'category_id' => 4,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Power supply DC variabel dengan output 0-30V dan arus maksimal 5A. Dilengkapi dengan proteksi arus lebih.',
            ],
            [
                'name' => 'Dual Channel Power Supply RIGOL DP832',
                'category_id' => 4,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Power supply 3 channel dengan output ±30V/3A dan 5V/3A.',
            ],
            [
                'name' => 'Trainer Kit Digital Logic',
                'category_id' => 4,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Kit praktikum untuk pembelajaran rangkaian logika digital dengan LED indicator.',
            ],
            [
                'name' => 'Trainer Kit Analog Electronics',
                'category_id' => 4,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Kit praktikum untuk pembelajaran elektronika analog dengan op-amp dan filter.',
            ],
            [
                'name' => 'Electronic Load Maynuo M9712',
                'category_id' => 4,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Electronic load programmable untuk testing power supply dan baterai.',
            ],

            // Peralatan Jaringan (Category 6)
            [
                'name' => 'Network Cable Tester',
                'category_id' => 6,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Cable tester untuk testing kabel UTP dan STP kategori 5e dan 6.',
            ],
            [
                'name' => 'Crimping Tool RJ45',
                'category_id' => 6,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Tang crimping untuk konektor RJ45 dan RJ11.',
            ],
            [
                'name' => 'Punch Down Tool',
                'category_id' => 6,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Punch down tool untuk instalasi kabel pada patch panel.',
            ],
            [
                'name' => 'WiFi Analyzer Fluke AirCheck G2',
                'category_id' => 6,
                'status' => 'borrowed',
                'condition' => 'good',
                'description' => 'Wireless network tester untuk troubleshooting jaringan WiFi.',
            ],

            // Microcontroller & Development Board (Category 7)
            [
                'name' => 'Arduino Uno R3 Starter Kit',
                'category_id' => 7,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Arduino Uno R3 dengan berbagai sensor dan aktuator untuk pembelajaran IoT.',
            ],
            [
                'name' => 'Raspberry Pi 4 Model B 4GB',
                'category_id' => 7,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Single board computer untuk project embedded system dan IoT.',
            ],
            [
                'name' => 'ESP32 Development Board',
                'category_id' => 7,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Microcontroller board dengan WiFi dan Bluetooth untuk aplikasi IoT.',
            ],
            [
                'name' => 'STM32 Nucleo-64 Board',
                'category_id' => 7,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Development board STM32 untuk pembelajaran embedded programming.',
            ],
            [
                'name' => 'FPGA Development Kit Xilinx Artix-7',
                'category_id' => 7,
                'status' => 'borrowed',
                'condition' => 'good',
                'description' => 'FPGA development kit untuk pembelajaran digital design dan VHDL.',
            ],

            // Peralatan Audio Video (Category 8)
            [
                'name' => 'Audio Signal Generator',
                'category_id' => 8,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Generator sinyal audio untuk testing sistem audio frequency.',
            ],
            [
                'name' => 'Audio Analyzer APx525',
                'category_id' => 8,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Audio analyzer untuk karakterisasi perangkat audio profesional.',
            ],
            [
                'name' => 'Video Signal Generator',
                'category_id' => 8,
                'status' => 'borrowed',
                'condition' => 'broken',
                'description' => 'Generator sinyal video untuk testing display dan monitor.',
            ],

            // Komponen Mekanik (Category 9)
            [
                'name' => 'Precision Screwdriver Set',
                'category_id' => 9,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Set obeng presisi untuk perbaikan perangkat elektronik kecil.',
            ],
            [
                'name' => 'Digital Caliper Mitutoyo',
                'category_id' => 9,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Jangka sorong digital dengan akurasi 0.01mm untuk pengukuran dimensi.',
            ],
            [
                'name' => 'PCB Drill Set 0.3-3.0mm',
                'category_id' => 9,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Set mata bor carbide untuk drilling PCB dengan berbagai ukuran.',
            ],
            [
                'name' => 'PCB Cutting Tool',
                'category_id' => 9,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Alat pemotong PCB dengan pisau carbide untuk hasil potongan yang rapi.',
            ],

            // Peralatan Keselamatan Kerja (Category 10)
            [
                'name' => 'Anti-Static Wrist Strap',
                'category_id' => 10,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Gelang anti-statis untuk melindungi komponen sensitif dari ESD.',
            ],
            [
                'name' => 'Safety Glasses with Side Shield',
                'category_id' => 10,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Kacamata pengaman untuk melindungi mata saat praktikum.',
            ],
            [
                'name' => 'Digital Insulation Tester',
                'category_id' => 10,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Insulation tester untuk testing isolasi kabel dan perangkat listrik.',
            ],
            [
                'name' => 'Ground Fault Circuit Interrupter Tester',
                'category_id' => 10,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'GFCI tester untuk testing keamanan instalasi listrik.',
            ],
            [
                'name' => 'Non-Contact Voltage Tester',
                'category_id' => 10,
                'status' => 'available',
                'condition' => 'good',
                'description' => 'Voltage tester non-contact untuk deteksi tegangan tanpa kontak fisik.',
            ],
        ];

        foreach ($tools as $tool) {
            Tool::create($tool);
        }
    }
}
