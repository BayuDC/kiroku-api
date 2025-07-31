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
            // Komponen Elektronik (Category 2)
            [
                'name' => 'Resistor 1kΩ 1/4W',
                'category_id' => 2,
                'stock' => 500,
                'description' => 'Resistor karbon film 1kΩ dengan toleransi 5% dan daya 1/4 watt. Warna: coklat-hitam-merah-emas.',
            ],
            [
                'name' => 'Resistor 10kΩ 1/4W',
                'category_id' => 2,
                'stock' => 400,
                'description' => 'Resistor karbon film 10kΩ dengan toleransi 5% dan daya 1/4 watt. Warna: coklat-hitam-oranye-emas.',
            ],
            [
                'name' => 'Resistor 100Ω 1/4W',
                'category_id' => 2,
                'stock' => 300,
                'description' => 'Resistor karbon film 100Ω dengan toleransi 5% dan daya 1/4 watt. Warna: coklat-hitam-coklat-emas.',
            ],
            [
                'name' => 'Kapasitor Elektrolit 100µF 25V',
                'category_id' => 2,
                'stock' => 200,
                'description' => 'Kapasitor elektrolit 100µF tegangan kerja 25V. Polaritas positif dan negatif harus diperhatikan.',
            ],
            [
                'name' => 'Kapasitor Elektrolit 1000µF 16V',
                'category_id' => 2,
                'stock' => 150,
                'description' => 'Kapasitor elektrolit 1000µF tegangan kerja 16V untuk filter supply dan coupling.',
            ],
            [
                'name' => 'Kapasitor Keramik 0.1µF 50V',
                'category_id' => 2,
                'stock' => 500,
                'description' => 'Kapasitor keramik 100nF untuk coupling dan decoupling dalam rangkaian digital.',
            ],
            [
                'name' => 'LED 5mm Merah',
                'category_id' => 2,
                'stock' => 300,
                'description' => 'LED 5mm warna merah dengan tegangan forward 2V dan arus maksimal 20mA.',
            ],
            [
                'name' => 'LED 5mm Hijau',
                'category_id' => 2,
                'stock' => 250,
                'description' => 'LED 5mm warna hijau dengan tegangan forward 2.2V dan arus maksimal 20mA.',
            ],
            [
                'name' => 'LED 5mm Biru',
                'category_id' => 2,
                'stock' => 200,
                'description' => 'LED 5mm warna biru dengan tegangan forward 3.2V dan arus maksimal 20mA.',
            ],
            [
                'name' => 'Dioda 1N4007',
                'category_id' => 2,
                'stock' => 400,
                'description' => 'Dioda penyearah silikon 1000V 1A untuk aplikasi power supply dan proteksi.',
            ],
            [
                'name' => 'Transistor NPN 2N2222',
                'category_id' => 2,
                'stock' => 200,
                'description' => 'Transistor NPN general purpose dengan frekuensi tinggi untuk switching dan amplifier.',
            ],
            [
                'name' => 'Transistor PNP 2N2907',
                'category_id' => 2,
                'stock' => 150,
                'description' => 'Transistor PNP complement untuk 2N2222, untuk aplikasi switching dan amplifier.',
            ],
            [
                'name' => 'IC Op-Amp LM358',
                'category_id' => 2,
                'stock' => 100,
                'description' => 'Dual operational amplifier dengan supply tunggal untuk aplikasi analog.',
            ],
            [
                'name' => 'IC Timer NE555',
                'category_id' => 2,
                'stock' => 120,
                'description' => 'IC timer serbaguna untuk aplikasi oscillator, timer, dan PWM generator.',
            ],
            [
                'name' => 'IC Logic 7400 NAND Gate',
                'category_id' => 2,
                'stock' => 80,
                'description' => 'Quad 2-input NAND gate TTL untuk rangkaian logika digital.',
            ],
            [
                'name' => 'IC Voltage Regulator 7805',
                'category_id' => 2,
                'stock' => 100,
                'description' => 'Voltage regulator 5V 1A dengan proteksi thermal dan short circuit.',
            ],
            [
                'name' => 'Potentiometer 10kΩ Linear',
                'category_id' => 2,
                'stock' => 50,
                'description' => 'Variable resistor 10kΩ dengan taper linear untuk kontrol analog.',
            ],
            [
                'name' => 'Crystal Oscillator 16MHz',
                'category_id' => 2,
                'stock' => 80,
                'description' => 'Crystal quartz 16MHz untuk clock generator microcontroller.',
            ],

            // Bahan Habis Pakai (Category 5)
            [
                'name' => 'Timah Solder 60/40 0.8mm',
                'category_id' => 5,
                'stock' => 10,
                'description' => 'Timah solder dengan komposisi 60% timah dan 40% timbal. Diameter 0.8mm dengan flux rosin core.',
            ],
            [
                'name' => 'Timah Solder Lead-Free 0.8mm',
                'category_id' => 5,
                'stock' => 8,
                'description' => 'Timah solder bebas timbal (SAC305) diameter 0.8mm untuk aplikasi RoHS compliant.',
            ],
            [
                'name' => 'Flux Paste',
                'category_id' => 5,
                'stock' => 15,
                'description' => 'Flux paste untuk membantu proses soldering, terutama untuk komponen SMD.',
            ],
            [
                'name' => 'Desoldering Braid',
                'category_id' => 5,
                'stock' => 20,
                'description' => 'Solder wick untuk membersihkan solder excess dari PCB.',
            ],
            [
                'name' => 'Isopropyl Alcohol 99%',
                'category_id' => 5,
                'stock' => 5,
                'description' => 'Isopropyl alcohol untuk pembersihan flux residue dan komponen elektronik.',
            ],
            [
                'name' => 'PCB Cleaner Spray',
                'category_id' => 5,
                'stock' => 8,
                'description' => 'Spray pembersih PCB untuk menghilangkan kontaminan dan flux residue.',
            ],

            // Alat Bantu Praktikum (Category 4)
            [
                'name' => 'Breadboard 830 Tie Points',
                'category_id' => 4,
                'stock' => 50,
                'description' => 'Breadboard untuk prototyping dengan 830 tie points. Ukuran standar dengan binding posts.',
            ],
            [
                'name' => 'Breadboard 400 Tie Points',
                'category_id' => 4,
                'stock' => 30,
                'description' => 'Breadboard mini untuk prototyping kecil dengan 400 tie points.',
            ],
            [
                'name' => 'Jumper Wire Male-Male',
                'category_id' => 4,
                'stock' => 100,
                'description' => 'Set kabel jumper male-male berbagai warna untuk breadboard.',
            ],
            [
                'name' => 'Jumper Wire Female-Female',
                'category_id' => 4,
                'stock' => 80,
                'description' => 'Set kabel jumper female-female untuk koneksi sensor dan module.',
            ],
            [
                'name' => 'Jumper Wire Male-Female',
                'category_id' => 4,
                'stock' => 80,
                'description' => 'Set kabel jumper male-female untuk koneksi Arduino dan breadboard.',
            ],
            [
                'name' => 'PCB Universal 5x7cm',
                'category_id' => 4,
                'stock' => 100,
                'description' => 'PCB universal single layer untuk prototyping permanen.',
            ],
            [
                'name' => 'IC Socket 8-pin DIP',
                'category_id' => 4,
                'stock' => 150,
                'description' => 'IC socket 8-pin DIP untuk mounting IC yang dapat diganti.',
            ],
            [
                'name' => 'IC Socket 14-pin DIP',
                'category_id' => 4,
                'stock' => 100,
                'description' => 'IC socket 14-pin DIP untuk mounting IC logika TTL.',
            ],

            // Peralatan Jaringan (Category 6)
            [
                'name' => 'Kabel UTP Cat6 per meter',
                'category_id' => 6,
                'stock' => 500,
                'description' => 'Kabel UTP kategori 6 untuk instalasi jaringan gigabit ethernet.',
            ],
            [
                'name' => 'Konektor RJ45',
                'category_id' => 6,
                'stock' => 200,
                'description' => 'Konektor RJ45 untuk terminasi kabel UTP Cat5e dan Cat6.',
            ],
            [
                'name' => 'Konektor RJ11',
                'category_id' => 6,
                'stock' => 100,
                'description' => 'Konektor RJ11 untuk aplikasi telepon dan modem.',
            ],

            // Microcontroller & Development Board (Category 7)
            [
                'name' => 'Sensor Ultrasonik HC-SR04',
                'category_id' => 7,
                'stock' => 30,
                'description' => 'Sensor jarak ultrasonik dengan range 2cm-400cm untuk project robotika.',
            ],
            [
                'name' => 'Sensor Suhu DS18B20',
                'category_id' => 7,
                'stock' => 40,
                'description' => 'Sensor suhu digital waterproof dengan interface 1-Wire.',
            ],
            [
                'name' => 'Module WiFi ESP8266',
                'category_id' => 7,
                'stock' => 25,
                'description' => 'Module WiFi untuk menambahkan konektivitas wireless pada microcontroller.',
            ],
            [
                'name' => 'Servo Motor SG90',
                'category_id' => 7,
                'stock' => 20,
                'description' => 'Servo motor micro 9g untuk aplikasi robotika dan automation.',
            ],
            [
                'name' => 'LCD Display 16x2 I2C',
                'category_id' => 7,
                'stock' => 15,
                'description' => 'LCD display 16x2 karakter dengan interface I2C untuk menghemat pin IO.',
            ],
        ];

        foreach ($consumables as $consumable) {
            Consumable::create($consumable);
        }
    }
}
