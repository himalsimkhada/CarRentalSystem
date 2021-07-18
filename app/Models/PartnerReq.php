<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerReq extends Model
{
    use HasFactory;

    protected $table = 'partner_reqs';

    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'company_description',
        'company_address',
        'company_contact',
        'company_reg',
        'company_email',
        'user_id',
        'approved',
    ];
}
