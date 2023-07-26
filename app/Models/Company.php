<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'company';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'address',
        'contact',
        'registration_number',
        'email',
        'logo',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class, 'company_id');
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Car::class, 'company_id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'company_id');
    }
    public function credentials()
    {
        return $this->hasMany(CompanyCredential::class, 'company_id');
    }
}
