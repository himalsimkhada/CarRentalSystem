<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CarCompany extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'companies';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'address',
        'contact',
        'registration_number',
        'email',
        'logo',
        'owner_id',
    ];

    public function car()
    {
        return $this->hasMany(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function location()
    {
        return $this->hasMany(Location::class);
    }
    public function credential()
    {
        return $this->hasOne(CompanyCredential::class);
    }
}
