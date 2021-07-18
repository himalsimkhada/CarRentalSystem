<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'contact_us';

    public $timestamps = false;

    protected $fillable = [
        'fullname',
        'email',
        'contact_num',
        'message',
        'type',
        'priority',
        'user_id',
        'status',
    ];
}
