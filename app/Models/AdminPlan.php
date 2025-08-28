<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPlan extends Model
{
    use HasFactory;
    
    protected $table = 'plans'; // 👈 force Laravel to use 'plans' table

    protected $fillable = [
        'name',
        'license_code',
        'product_limit',
        'license_limit',
        'price',
    ];

    protected $casts = [
        'license_code' => 'array', // agar JSON use karega
    ];
}
