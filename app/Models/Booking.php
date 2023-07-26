<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    public $timestamps = false;

    protected $fillable = [
        'booking_date',
        'date',
        'return_date',
        'status',
        'payment',
        'booking_type_id',
        'car_id',
        'user_id',
        'location_id',
        'final_cost',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function bookingType()
    {
        return $this->belongsTo(BookingType::class);
    }

    // public function company()
    // {
    //     return $this->belongsToThrough
    // }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
