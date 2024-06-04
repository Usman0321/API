<?php

namespace Database\Seeders;

use App\Models\amenity;
use App\Models\hotel;
use App\Models\room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use faker\Factory as faker;
class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = faker::create();
        $hotelId = hotel::pluck('id')->toArray();
        // $amenityId = amenity::pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
        $availablity = ['available', 'booked', 'reserved'];
        $randomStatus = $availablity[array_rand($availablity)];

            room::create([
                // 'room_type' => array_rand(['single' , 'twin' , 'delux']),
                // 'amenities' => $amenityId[array_rand($amenityId)],
                'room_number' => rand(1,1000),
                'room_capacity' => rand(1,5),
                'hotel_id' => $hotelId[array_rand($hotelId)],
                'price_per_night' => rand(10,50) * 100,
                'availability' => $randomStatus,
            ]);
        }
    }
}
