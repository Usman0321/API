<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amenity extends Model
{
    use HasFactory;
    public function room(){
        $this->hasMany(room::class);
    }
    public function roomAmenities(){
        $this->hasMany(room_amenity::class);
    }

    public $fillable = [
        'icon',
        'name',
    ];
}
