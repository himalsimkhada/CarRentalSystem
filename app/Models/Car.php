<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $table = 'cars';

    public $timestamps = false;

    protected $fillable = [
        'model',
        'description',
        'model_year',
        'brand',
        'color',
        'primary_image',
        'plate_number',
        'availability',
        'company_id',
        'booking_type_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bookingType()
    {
        return $this->belongsTo(BookingType::class, 'booking_type_id');
    }
    public function carImages()
    {
        return $this->hasMany(CarImage::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'car_id');
    }
}
