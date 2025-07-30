<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\User;
use App\Models\Tool;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoanSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Get staff members for the foreign key
        $staffMembers = User::where('role', 'staff')->get();

        // Get tools for the pivot table
        $tools = Tool::all();

        if ($staffMembers->isEmpty() || $tools->isEmpty()) {
            $this->command->info('Please run UserSeeder and ToolSeeder first');
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
            'Mahasiswa - Nanda Prasetya',
            'Mahasiswa - Oktavia Sari',
            'Dosen - Dr. Putra Wijaya',
            'Mahasiswa - Qori Rahman',
            'Mahasiswa - Rika Mentari',
        ];

        // Tool conditions
        $conditions = ['good', 'broken'];

        // Create loan records
        $loans = [];

        for ($i = 0; $i < 30; $i++) {
            $loanDate = Carbon::now()->subDays(rand(1, 120))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // 70% chance the loan has been returned, 30% still active
            $isReturned = rand(1, 100) <= 70;
            $returnDate = null;

            if ($isReturned) {
                // Return date should be after loan date, within 1-30 days
                $returnDate = (clone $loanDate)->addDays(rand(1, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59));

                // Make sure return date is not in the future
                if ($returnDate->isAfter(Carbon::now())) {
                    $returnDate = Carbon::now()->subDays(rand(1, 7));
                }
            }

            $loan = Loan::create([
                'used_by' => $usedByNames[array_rand($usedByNames)],
                'loan_date' => $loanDate,
                'return_date' => $returnDate,
                'staff_id' => $staffMembers->random()->id,
            ]);

            // Attach random tools with conditions
            $randomTools = $tools->random(rand(1, 4));

            foreach ($randomTools as $tool) {
                $conditionBefore = $conditions[array_rand($conditions)];
                $conditionAfter = null;

                // Only set condition_after if the loan has been returned
                if ($isReturned) {
                    // 90% chance condition stays the same, 10% chance it gets damaged
                    if ($conditionBefore === 'good') {
                        $conditionAfter = rand(1, 100) <= 90 ? 'good' : 'broken';
                    } else {
                        $conditionAfter = 'broken'; // If it was already broken, it stays broken
                    }
                }

                $loan->tools()->attach($tool->id, [
                    'condition_before' => $conditionBefore,
                    'condition_after' => $conditionAfter,
                ]);
            }

            $loans[] = $loan;
        }

        $returnedCount = collect($loans)->filter(function ($loan) {
            return $loan->return_date !== null;
        })->count();

        $activeCount = count($loans) - $returnedCount;

        $this->command->info('Created ' . count($loans) . ' loan records:');
        $this->command->info('- ' . $returnedCount . ' returned loans');
        $this->command->info('- ' . $activeCount . ' active loans');
    }
}
