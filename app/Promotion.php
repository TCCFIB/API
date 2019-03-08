<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\PromotionReport;
use App\PromotionLike;

class Promotion extends Model
{
    use SoftDeletes;

    public $table = 'promotions';

    protected $fillable = [
        'name',
        'value',
        'location',
        'user_id',
        'product_id',
        'like',
        'start',
        'end'
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function promotionLike()
    {
        return $this->belongsTo(PromotionLike::class, 'promotion_id', 'id');
    }

    public function promotionReports()
    {
        return $this->belongsTo(PromotionReport::class, 'promotion_id', 'id');
    }

    public function scopeSearch($query, Request $request) 
    {
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%'.strtolower($request->input('name')).'%');
        }

        if ($request->has('value')) {
            $query->where('value', 'LIKE', '%'.strtolower($request->input('value')).'%');
        }

        if ($request->has('coordinates')) {
            $query->where('coordinates', 'LIKE', '%'.strtolower($request->input('coordinates')).'%');
        }

        if ($request->has('location')) {
            $query->where('location', 'LIKE', '%'.strtolower($request->input('location')).'%');
        }

        if ($request->has('zip_code')) {
            $query->where('zip_code', 'LIKE', '%'.strtolower($request->input('zip_code')).'%');
        }

        if ($request->has('limit') && !empty($request->input('limit'))) {
            $query->limit($request->input('limit'));
        }

        if ($request->has('offset') && !empty($request->input('offset'))) {
            $query->offset($request->input('offset'));
        }

        return $query->get();
    }
    
}
