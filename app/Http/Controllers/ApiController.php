<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Resources\News as NewsResource;
use App\Http\Resources\GalleryItems as GalleryItemsResource;
use App\News;
use App\Gallery;
use App\GalleryItem;
use App\LeagueCalendar;
use App\TeamLeague;
use App\UserPrediction;
use PhpParser\Node\Expr\Array_;

class ApiController extends Controller
{
    public function getNews()
    {
        //$news = News::all();
        return NewsResource::collection(News::all());
    }

    public function prediction(Request $request)
    {
        $games = json_decode($request->games);
        $fanId = $request->fanId;
        $type = $request->type;
        $messages = [
            'required' => 'پر کردن این فیلد اجباری است!',
            'numeric' => 'ورودی باید به صورت عدد باشد',
            'integer' => 'ورودی باید به صورت عدد باشد',
        ];
        $validatedData = Validator::make($request->all(), [
            'fanId' => 'required|numeric|integer'
        ], $messages);
        if (!$validatedData->fails()) {
            if (!empty($fanId) && !empty($games) && !empty($type)) {

                foreach ($games as $game) {
                    $this->predictGame($game, $fanId, $type);
                }
            }
        }
    }

    public function predictGame($game, $fanId, $type)
    {
        //dd($fanId);
        $game_id = $game->id; //league_calendar_id
        $game_fanId = $fanId;
        $team1Goals = $game->team1Goals;
        $team2Goals = $game->team2Goals;
        $gameInsert = LeagueCalendar::where('id', $game_id)->first();

        if (!empty($gameInsert)) {
            $gamePrediction = new UserPrediction();
            $gamePrediction->league_calendar_id = $gameInsert->id;
            $gamePrediction->fan_id = $game_fanId;
            $gamePrediction->team1_goals = $team1Goals;
            $gamePrediction->team2_goals = $team2Goals;
            $gamePrediction->type = $type;
            $gamePrediction->save();
        }
    }
    public function fetchGallery(Request $request)
    {
        $gallery = Gallery::where('id', $request->id)->first();

        $galleryItems = GalleryItem::where('gallery_id', $gallery->id)->get();
        return GalleryItemsResource::collection($galleryItems);
    }
    
    public function fetchTeams()
    {

        $teams = TeamLeague::all();
dd($teams);
        return SearchResource::collection($products);
    }
}
