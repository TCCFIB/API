<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Promotion;
use Illuminate\Http\Request;

class Product extends Model
{
    use SoftDeletes;
	
    public $table = 'products';

    protected $fillable = [
        'name',
        'description',
        // 'prescription'
    ];

    public $timestamps = true;

    public function promotions()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'id');
    }

    public function scopeSearch($query, Request $request) 
    {
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%'.strtolower($request->input('name')).'%');
        }

        if ($request->has('prescription')) {
            $query->where('prescription', 'LIKE', '%'.strtolower($request->input('prescription')).'%');
        }

        if ($request->has('limit') && !empty($request->input('limit'))) {
            $query->limit($request->input('limit'));
        }

        if ($request->has('offset') && !empty($request->input('offset'))) {
            $query->offset($request->input('offset'));
        }

        return $query->with('promotions')->get();
    }
}
