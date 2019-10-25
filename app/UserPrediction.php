<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserPrediction extends Model
{
    public function game()
    {
        return $this->belongsTo('App\LeagueCalendar','league_calendar_id');
    }
    
}
