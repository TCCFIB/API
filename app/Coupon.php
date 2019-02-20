<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Coupon extends Model
{
    use SoftDeletes;

    public $table = 'coupons';
    
    protected $fillable = [
        'name',
        'description'
    ];

    public $timestamps = true;
}
