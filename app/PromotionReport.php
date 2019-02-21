<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Promotion;

class PromotionReport extends Model
{
    public $table = 'promotion_report';

    protected $fillable = [
        'comment',
        'promotion_id',
        'user_id'
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function promotions()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'id');
    }
}
