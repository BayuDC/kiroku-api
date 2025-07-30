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
            'Mahasiswa - Andi Pratama',
            'Mahasiswa - Siti Nurhaliza',
            'Mahasiswa - Budi Setiawan',
            'Mahasiswa - Dina Kartika',
            'Mahasiswa - Eko Prasetyo',
            'Dosen - Prof. Dr. Ahmad Suharto',
            'Dosen - Dr. Ratna Sari',
            'Mahasiswa - Fajar Ramadhan',
            'Mahasiswa - Gita Permata',
            'Dosen - Ir. Hendra Wijaya, M.T.',
            'Mahasiswa - Indira Kusuma',
            'Mahasiswa - Joko Susilo',
            'Teknisi - Karyawan Lab',
            'Mahasiswa - Lisa Anggraini',
            'Mahasiswa - Muhammad Rizki',
        ];

        // Create usage records
        $usages = [];

        for ($i = 0; $i < 25; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            $usage = Usage::create([
                'used_by' => $usedByNames[array_rand($usedByNames)],
                'date' => $randomDate,
                'staff_id' => $staffMembers->random()->id,
            ]);

            // Attach random consumables with quantities
            $randomConsumables = $consumables->random(rand(1, 3));

            foreach ($randomConsumables as $consumable) {
                $usage->consumables()->attach($consumable->id, [
                    'quantity' => rand(1, 10),
                ]);
            }

            $usages[] = $usage;
        }

        $this->command->info('Created ' . count($usages) . ' usage records with associated consumables');
    }
}
