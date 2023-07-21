<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function car()
    {
        return $this->hasMany(Car::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
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
