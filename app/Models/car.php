<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    public function subImages(){
        return $this->hasMany(carImage::class);
    }
    protected $fillable = [
        'name',
        'type',
        'license_plate',
        'capacity',
        'price_per_day',
        'description',
        'availability_status',
        'main_image',
    ];
}
