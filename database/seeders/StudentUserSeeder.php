<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;

class StudentUserSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'username' => 'Finn',
                'full_name' => 'Finn Mertens',
                'email' => 'finn@gmail.com',
            ],
            [
                'username' => 'Jake',
                'full_name' => 'Jake Junior',
                'email' => 'jake@gmail.com',
            ],
            [
                'username' => 'Betty',
                'full_name' => 'Betty Petrikov',
                'email' => 'pbubblegum@gmail.com',
            ],
            [
                'username' => 'Marceline',
                'full_name' => 'Marceline Abadeer',
                'email' => 'marceline@gmail.com',
            ],
            [
                'username' => 'Bmo',
                'full_name' => 'BMO',
                'email' => 'bmo@gmail.com',
            ],
            [
                'username' => 'Simon',
                'full_name' => 'Simon Petrikov',
                'email' => 'iceking@gmail.com',
            ],
            [
                'username' => 'Fionna',
                'full_name' => 'Fionna Mertens',
                'email' => 'flameprincess@gmail.com',
            ],
            [
                'username' => 'Lemongrab',
                'full_name' => 'Earl of Lemongrab',
                'email' => 'lemongrab@gmail.com',
            ],
            [
                'username' => 'Lsp',
                'full_name' => 'Lumpy Space',
                'email' => 'lsp@gmail.com',
            ],
            [
                'username' => 'Hunson',
                'full_name' => 'Hunson Abadeer',
                'email' => 'hunson@gmail.com',
            ],
        ];

        foreach ($students as $i => $studentData) {
            $user = User::create([
                'username'   => $studentData['username'],
                'full_name'  => $studentData['full_name'],
                'email'      => $studentData['email'],
                'password'   => Hash::make('password123'), 
                // role tidak perlu ditulis karena default 'user'
            ]);

            Student::create([
                'user_id'    => $user->user_id,
                'entry_year' => 2020 + ($i % 4), // variasi 2020-2023
            ]);
        }
    }
}
