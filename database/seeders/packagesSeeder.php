<?php

namespace Database\Seeders;

use App\Models\package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class packagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            for ($i = 0; $i < 10; $i++) {
                $data = [
                    'package_name' => 'Package ' . ($i + 1),
                    'package_type' => ['Standard', 'Premium', 'Deluxe'][rand(0, 2)],
                    'price' => rand(100, 1000),
                    'duration' => rand(1, 14) . ' days',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'hotel_details' => rand(17, 25), // Assuming there are 20 hotel records
                    'laugage_capacity' => rand(10, 50) . ' kg',
                    'group_size' => rand(1, 10),
                    'departure_date' => now()->addDays(rand(1, 30))->toDateString(),
                    'return_date' => now()->addDays(rand(31, 60))->toDateString(),
                    'contact_information' => 'Contact us for more details',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                package::insert($data);
            }
    }
}
