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

        // Tool conditions
        $conditions = ['good', 'broken'];

        // Create loan records
        $loans = [];

        for ($i = 0; $i < 50; $i++) {
            $loanDate = Carbon::now()->subDays(rand(1, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // 75% chance the loan has been returned, 25% still active
            $isReturned = rand(1, 100) <= 75;
            $returnDate = null;

            if ($isReturned) {
                // Return date should be after loan date, within 1-45 days
                $returnDate = (clone $loanDate)->addDays(rand(1, 45))->addHours(rand(0, 23))->addMinutes(rand(0, 59));

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

            // Attach random tools with conditions (1-5 tools per loan)
            $randomTools = $tools->random(rand(1, 5));

            foreach ($randomTools as $tool) {
                $conditionBefore = $conditions[array_rand($conditions)];
                $conditionAfter = null;

                // Only set condition_after if the loan has been returned
                if ($isReturned) {
                    // 95% chance condition stays the same, 5% chance it gets damaged
                    if ($conditionBefore === 'good') {
                        $conditionAfter = rand(1, 100) <= 95 ? 'good' : 'broken';
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
