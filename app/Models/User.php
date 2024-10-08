<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'address',
        'contact',
        'date_of_birth',
        'profile_photo',
        'username',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // public function isAdmin()
    // {
    //     if ($this->user_type == 1) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function credentials()
    {
        return $this->hasMany(UserCredential::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        $filename = $this->profile_photo;
        $url = asset('public/images/profile_images/' . $filename);

        return $url;
    }
}
