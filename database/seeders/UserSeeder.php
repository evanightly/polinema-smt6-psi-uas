<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        $data = [
            [
                'name' => 'Rendra',
                'email' => 'rendra@gmail.com',
                'password' => Hash::make('rendra')
            ],
            [
                'name' => 'Chandra',
                'email' => 'chandra@gmail.com',
                'password' => Hash::make('chandra')
            ],
            [
                'name' => 'Rosa Andre',
                'email' => 'rosa@gmail.com',
                'password' => Hash::make('rosa')
            ]
        ];

        foreach ($data as $item) {
            User::factory()->create($item);
        }
    }
}
