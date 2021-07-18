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

    public function car()
    {
        return $this->hasOne(Car::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function type()
    {
        return $this->hasOne(BookingType::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
