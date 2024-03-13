<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call(
            [
                RoleSeeder::class,
                UserSeeder::class,
                SupplierSeeder::class,
                ProductSeeder::class,
                TransactionSeeder::class,
            ]
        );

        // User::find(1)->assignRole('Staff');
    }
}
