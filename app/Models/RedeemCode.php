<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'redeem_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'redeem_codes',
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'redeem_code', 'redeem_code');
    }
}
