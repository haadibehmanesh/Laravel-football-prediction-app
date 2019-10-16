<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Resources\News as NewsResource;
use App\Http\Resources\GalleryItems as GalleryItemsResource;
use App\Http\Resources\TeamStandings as TeamStandingsResource;
use App\Http\Resources\Games as GamesResource;
use App\Http\Resources\UserInfo as UserInfoResource;
use App\News;
use App\Gallery;
use App\GalleryItem;
use App\LeagueCalendar;
use App\TeamLeague;
use App\UserPrediction;
use App\Fan;
use App\FanScore;
use App\Team;
use PhpParser\Node\Expr\Array_;

class ApiController extends Controller
{
    public function getNews(Request $request)
    {
        
        $pagination  = $request->pagination;
        return NewsResource::collection(News::paginate($pagination));
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
        $pagination  = $request->pagination;
        $galleryItems = GalleryItem::where('gallery_id', $gallery->id)->paginate($pagination);
        return GalleryItemsResource::collection($galleryItems);
    }
    
    public function fetchTeams(Request $request)
    {
        $pagination  = $request->pagination;
        
        $teams = TeamLeague::paginate($pagination);
        
        return TeamStandingsResource::collection($teams);
    }
    public function fetchUserInfo(Request $request)
    {
       
        $fan = Fan::where('id',$request->id)->first();
        if($fan){

         //   $wallet = Wallet::where('customer_id', $customer->id)->where('status','completed')->orderBy('id','desc')->first();
           
            $score = FanScore::where('fan_id', $fan->id)->first();
            
    
            if(!empty($score)){
                $score = $score->score_value;
                $fan->setAttribute('score', $score);
            }else{
                $score = 0 ;
            }
        }
       
     
       
      
       // $collection = collect(['score' => $score,'total' =>$total]);
     //  dd($customer);
      return new UserInfoResource($fan);
       // return UserInfoResource::collection($score);
        
    }
    public function fetchGames(Request $request)
    {
        $pagination  = $request->pagination;
        
        $teams = LeagueCalendar::paginate($pagination);
        foreach ($teams as $team ) {
            
            $team1 = Team::where('id',$team->team1_id)->first();
            $team2 = Team::where('id',$team->team2_id)->first();
            $team->setAttribute('team1_name', $team1->name);
            $team->setAttribute('team2_name', $team2->name);
            //dd($team);
        }
        //dd($teams);
        return GamesResource::collection($teams);
    }
}
