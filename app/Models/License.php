<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_use_limit',
        'license_expiration_date',
        'product_id',
        'product_name',
        'license_codes',
        'user_id'
    ];

    
}
