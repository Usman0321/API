<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hotel extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    function city(){
        // return  $this->hasOne('App\Models\city' , 'city_id');
        return  $this->belongsTo(city::class , 'city_id');
    }
    function hotelReview(){
        return  $this->hasMany(hotelReview::class);
    }
    // function room(){
    //     return  $this->hasMany(room::class);
    // }
    public $fillable = [
        'hotel_name' ,
        'location' ,
        'description' ,
        'city_id'
    ];
}
