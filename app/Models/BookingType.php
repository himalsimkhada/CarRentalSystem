<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    use HasFactory;

    protected $table = 'booking_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'luggage_no',
        'people_no',
        'cost',
        'late_fee',
        'count_reservation',
    ];

    public function book()
    {
        return $this->hasMany(Booking::class);
    }

    public function car()
    {
        return $this->hasMany(Car::class);
    }
}
