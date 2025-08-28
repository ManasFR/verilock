<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidLicense extends Model
{
    use HasFactory;

    protected $fillable = ['user_email', 'product_id', 'user_license', 'domain', 'active', 'user_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    

}
