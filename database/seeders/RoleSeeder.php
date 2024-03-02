<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $data = [
            [
                'name' => 'Staff',
                'description' => 'Penjual di Kantin',
            ],
            [
                'name' => 'Pengelola',
                'description' => 'Pengelola Kantin',
            ],
        ];

        foreach ($data as $item) {
            Role::factory()->create($item);
        }
    }
}
