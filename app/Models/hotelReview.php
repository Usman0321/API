<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hotelReview extends Model
{
    use HasFactory;
    public function hotel(){
        return $this->belongsTo(hotel::class);
    }
    public function user(){
        return $this->belongsTo(user::class);
    }
    protected $fillable =[
        'user_id',
        'hotel_id',
        'rating',
        'review-description',
    ];
}
