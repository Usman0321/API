<?php

namespace Database\Seeders;

use App\Models\city;
use App\Models\hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class HotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i=0; $i < 20 ; $i++) {
            // hotel::create([
            //     'hotel_name' => $faker->company,
            //     'city_id' => rand(1,5),
            // ]);

            $cityIds = city::pluck('id')->toArray();
            hotel::create(['hotel_name' => 'Schoen-Murray', 'city_id' =>$faker->randomElement($cityIds) , 'created_at' => now(), 'updated_at' => now()
                // Add more hotels as needed
            ]);
        }

    }
}
