<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCredential extends Model
{
    use HasFactory;

    protected $table = 'company_credentials';

    public $timestamps = false;

    protected $fillable = [
        'credential_name',
        'credential_id',
        'credential_file',
        'image',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
