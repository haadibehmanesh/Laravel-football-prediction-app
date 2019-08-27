<?php

namespace App\Http\Controllers\Voyager;

use App\FanScore;
use App\LeagueCalendar;
use App\UserPrediction;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Models\Post;


class ValidatePredictionController extends VoyagerBaseController
{
    public function validatePrediction()
    {
        $game = LeagueCalendar::where('id', \request("id"))->first();

        if (!is_null($game->team1_goals)) {

            if (!is_null($game->team2_goals)) {
                if ($game->team1_goals > $game->team2_goals) {
                    $realwinner = $game->team1_id;
                    $equal = 0;
                } elseif ($game->team1_goals < $game->team2_goals) {
                    $realwinner = $game->team2_id;
                    $equal = 0;
                } else {
                    $realwinner = null;
                    $equal = 1;
                }

                $game->status = $game->status == "PENDING" ? "VALIDATED" : "PENDING";
                $game->save();
            }
        }
        $gamePredictions = UserPrediction::where('league_calendar_id', $game->id)->get();
        // dd($gamePredictions);
        foreach ($gamePredictions as $gamePredicted) {
            if ($gamePredicted->scored != 1) {
            if (($gamePredicted->team1_goals == $game->team1_goals) and ($gamePredicted->team2_goals == $game->team2_goals)) {
                $gamePredicted->status = 'PERFECT';

                // $gamePredicted->save();
                    $last_score = FanScore::where('fan_id', $gamePredicted->fan_id)->first();
                    $score = FanScore::firstOrNew([
                        'fan_prediction_id' => $gamePredicted->id,
                        'fan_id' => $gamePredicted->fan_id,
                    ]);
                    $score->score_value = +10;

                    if (!empty($last_score)) {
                        $score->total = $score->score_value + $last_score->total;
                    } else {
                        $score->total = $score->score_value;
                    }
                    $score->save();
                    $gamePredicted->scored = 1;
                    $gamePredicted->save();
                } elseif ($gamePredicted->winner == $realwinner) {
                    $gamePredicted->status = 'SEMI';
                    // $gamePredicted->save();
                    $last_score = FanScore::where('fan_id', $gamePredicted->fan_id)->first();
                    $score = FanScore::firstOrNew([
                        'fan_prediction_id' => $gamePredicted->id,
                        'fan_id' => $gamePredicted->fan_id
                    ]);
                    $score->score_value = +5;

                    if (!empty($last_score)) {
                        $score->total = $score->score_value + $last_score->total;
                    } else {
                        $score->total = $score->score_value;
                    }

                    $score->save();
                    $gamePredicted->scored = 1;
                    $gamePredicted->save();
                }
            }
        }


        return redirect(route('voyager.league-calendars.index'));
    }
}
