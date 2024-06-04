<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    use HasFactory;
    public  function hotel(){
        return $this->belongsTo(hotel::class, 'hotel_details' , 'id');
    }
    protected $fillable = [
        'package_name',
        'package_type',
        'price',
        'duration',
        'description',
        'hotel_details',
        'laugage_capacity',
        'group_size',
        'departure_date',
        'return_date',
        'contact_information',
    ];
}
