<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Create 1 admin
        User::create([
            'name' => 'Dr. Budi Santoso',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create 3 staff members
        $staffMembers = [
            [
                'name' => 'Sari Elektronika',
                'username' => 'sari_staff',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ],
            [
                'name' => 'Ahmad Teknik',
                'username' => 'ahmad_staff',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ],
            [
                'name' => 'Rina Listrik',
                'username' => 'rina_staff',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ],
        ];

        foreach ($staffMembers as $staff) {
            User::create($staff);
        }
    }
}
