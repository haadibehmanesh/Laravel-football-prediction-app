<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Http\Resources\News as NewsResource;
use App\News;
use App\LeagueCalendar;
use App\UserPrediction;

class ApiController extends Controller
{
    public function getNews()
    {
        //$news = News::all();
        return NewsResource::collection(News::all());
    }
    public function predictGame(Request $request)
    {


         //dd($request);
         $game_id = $request->id;
         $fan_id = $request->fanId;
         $team1Goals = $request->team1Goals;
         $team2Goals = $request->team2Goals;
         $messages = [
             'required' => 'پر کردن این فیلد اجباری است!',
             'numeric' => 'ورودی باید به صورت عدد باشد',
             'integer' => 'ورودی باید به صورت عدد باشد',
            // 'min' => 'ورودی نمی تواند 0 یا منفی باشد',
         ];
         $validatedData = Validator::make($request->all(), [
             'id' => 'required|numeric|integer',
             'team1Goals' => 'required|numeric|integer',
             'team2Goals' => 'required|numeric|integer'
         ], $messages);
         if (!$validatedData->fails()) {
            $game = LeagueCalendar::where('id', $game_id)->first(); 
          
            if (!empty($game)) {
                $gamePrediction = new UserPrediction();
                $gamePrediction->league_calendar_id = $game->id;
                $gamePrediction->fan_id = $fan_id;
                $gamePrediction->team1_goals = $team1Goals;
                $gamePrediction->team2_goals = $team2Goals;
                $gamePrediction->save();
            } 
           
           
         }
       // $children = BiProduct::where('parent_id', $request->id)->orderBy('sort_order', 'desc')->where('status', 1)->get();
        // dd($children);
        //return ChildrenResource::collection($children);
    }
}
