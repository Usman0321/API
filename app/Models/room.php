<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;
    // function hotel(){
    //     $this->belongsTo(hotel::class);
    // }
    function amenitiesInfo(){
        $this->belongsToMany(amenity::class , 'room_id');
    }

     public function roomAmenities()
    {
        return $this->hasMany(room_amenity::class , 'room_id' , 'id');
    }

    public function amenities()
    {
        return $this->hasManyThrough(Amenity::class, room_amenity::class, 'room_id', 'id', 'id', 'amenity_id');
    }



    protected $fillable = [
        // 'room_type',
        // 'amenities',
        'room_number',
        'room_capacity',
        'hotel_id',
        'price_per_night',
        'availability'
    ];
    protected $casts = [
        'amenities' => 'array'
    ];

}
