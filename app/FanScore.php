<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FanScore extends Model
{
    protected $fillable = [
        'fan_id', 'score_value','fan_prediction_id','score_plan_id'
    ];
    public function fan()
    {
        return $this->belongsTo('App\Fan','fan_id');
    }
    
}
