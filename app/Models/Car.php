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
        return $this->belongsTo(CarCompany::class);
    }

    public function type()
    {
        return $this->belongsTo(BookingType::class, 'booking_type_id');
    }
    public function image()
    {
        return $this->hasMany(CarImage::class);
    }
    public function book()
    {
        return $this->hasOne(Booking::class);
    }
    public function review()
    {
        return $this->hasOne(CarReview::class);
    }
}
