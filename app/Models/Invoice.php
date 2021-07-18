<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    public $timestamps = true;

    protected $fillable = [
        'paypal_payer_id',
        'transaction_id',
        'paypal_email_address',
        'create_time',
        'update_time',
        'paypal_payer_name',
        'amount',
        'address',
        'booking_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
