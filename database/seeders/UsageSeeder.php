<?php

namespace Database\Seeders;

use App\Models\Usage;
use App\Models\User;
use App\Models\Consumable;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsageSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Get staff members for the foreign key
        $staffMembers = User::where('role', 'staff')->get();

        // Get consumables for the pivot table
        $consumables = Consumable::all();

        if ($staffMembers->isEmpty() || $consumables->isEmpty()) {
            $this->command->info('Please run UserSeeder and ConsumableSeeder first');
            return;
        }

        // Sample student/faculty names for 'used_by' field
        $usedByNames = [
            'Mahasiswa - Andi Pratama (1801234001)',
            'Mahasiswa - Siti Nurhaliza (1801234002)',
            'Mahasiswa - Budi Setiawan (1801234003)',
            'Mahasiswa - Dina Kartika (1801234004)',
            'Mahasiswa - Eko Prasetyo (1801234005)',
            'Dosen - Prof. Dr. Ahmad Suharto',
            'Dosen - Dr. Ratna Sari, M.T.',
            'Mahasiswa - Fajar Ramadhan (1801234006)',
            'Mahasiswa - Gita Permata (1801234007)',
            'Dosen - Ir. Hendra Wijaya, M.T.',
            'Mahasiswa - Indira Kusuma (1801234008)',
            'Mahasiswa - Joko Susilo (1801234009)',
            'Teknisi - Bambang Sutrisno',
            'Mahasiswa - Lisa Anggraini (1801234010)',
            'Mahasiswa - Muhammad Rizki (1801234011)',
            'Mahasiswa - Nanda Prasetya (1801234012)',
            'Mahasiswa - Oktavia Sari (1801234013)',
            'Dosen - Dr. Putra Wijaya, S.T., M.T.',
            'Mahasiswa - Qori Rahman (1801234014)',
            'Mahasiswa - Rika Mentari (1801234015)',
            'Mahasiswa - Sandi Kurniawan (1801234016)',
            'Mahasiswa - Tuti Rahayu (1801234017)',
            'Mahasiswa - Usman Hakim (1801234018)',
            'Dosen - Prof. Dr. Ir. Vera Susanti',
            'Mahasiswa - Wulan Dari (1801234019)',
            'Mahasiswa - Xavier Nugroho (1801234020)',
            'Mahasiswa - Yanti Permatasari (1801234021)',
            'Mahasiswa - Zaki Maulana (1801234022)',
            'Dosen - Dr. Eng. Arief Budiman',
            'Mahasiswa - Ayu Lestari (1801234023)',
            'Mahasiswa - Bryan Saputra (1801234024)',
            'Mahasiswa - Cindy Maharani (1801234025)',
            'Mahasiswa - Dedi Firmansyah (1801234026)',
            'Mahasiswa - Erna Widiastuti (1801234027)',
            'Teknisi - Firman Santoso',
            'Mahasiswa - Galuh Pertiwi (1801234028)',
            'Mahasiswa - Hadi Purnomo (1801234029)',
            'Mahasiswa - Irma Sari (1801234030)',
            'Dosen - Dr. Jatmiko Endro Suseno, S.T., M.T.',
            'Mahasiswa - Kiki Amelia (1801234031)',
            'Mahasiswa - Lutfi Hakim (1801234032)',
            'Mahasiswa - Maya Sari (1801234033)',
            'Mahasiswa - Novi Andriani (1801234034)',
            'Mahasiswa - Omar Sharif (1801234035)',
            'Dosen - Prof. Dr. Pramudita Sari',
            'Mahasiswa - Qonita Rahma (1801234036)',
            'Mahasiswa - Rizal Fauzi (1801234037)',
            'Mahasiswa - Siska Amelia (1801234038)',
            'Mahasiswa - Tri Wahyuni (1801234039)',
            'Mahasiswa - Udin Saepudin (1801234040)',
        ];

        // Create usage records
        $usages = [];

        for ($i = 0; $i < 50; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 150))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            $usage = Usage::create([
                'used_by' => $usedByNames[array_rand($usedByNames)],
                'date' => $randomDate,
                'staff_id' => $staffMembers->random()->id,
            ]);

            // Attach random consumables with realistic quantities based on the type of consumable
            $randomConsumables = $consumables->random(rand(1, 6));

            foreach ($randomConsumables as $consumable) {
                // Set realistic quantities based on consumable type
                $quantity = 1;

                if (
                    str_contains(strtolower($consumable->name), 'resistor') ||
                    str_contains(strtolower($consumable->name), 'led') ||
                    str_contains(strtolower($consumable->name), 'dioda')
                ) {
                    $quantity = rand(1, 20); // Small components used in quantity
                } elseif (
                    str_contains(strtolower($consumable->name), 'kapasitor') ||
                    str_contains(strtolower($consumable->name), 'transistor')
                ) {
                    $quantity = rand(1, 10); // Medium quantity components
                } elseif (
                    str_contains(strtolower($consumable->name), 'ic') ||
                    str_contains(strtolower($consumable->name), 'sensor') ||
                    str_contains(strtolower($consumable->name), 'module')
                ) {
                    $quantity = rand(1, 3); // Expensive components used sparingly
                } elseif (
                    str_contains(strtolower($consumable->name), 'jumper') ||
                    str_contains(strtolower($consumable->name), 'socket')
                ) {
                    $quantity = rand(1, 15); // Connection components
                } elseif (
                    str_contains(strtolower($consumable->name), 'kabel') ||
                    str_contains(strtolower($consumable->name), 'konektor')
                ) {
                    $quantity = rand(1, 5); // Cable and connectors
                } elseif (
                    str_contains(strtolower($consumable->name), 'breadboard') ||
                    str_contains(strtolower($consumable->name), 'pcb')
                ) {
                    $quantity = rand(1, 2); // Boards usually 1-2 pieces
                } else {
                    $quantity = rand(1, 5); // Default quantity for other items
                }

                $usage->consumables()->attach($consumable->id, [
                    'quantity' => $quantity,
                ]);
            }

            $usages[] = $usage;
        }

        $this->command->info('Created ' . count($usages) . ' usage records with associated consumables');
    }
}
