<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    public $timestamps = false;

    protected $fillable = [
        'location',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(CarCompany::class, 'company_id');
    }
}
