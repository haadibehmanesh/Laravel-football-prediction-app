<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Fan; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
class FanController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        
        if(Auth::guard('fan')->attempt(['phone' => request('phone'), 'password' => request('password')])){ 
            $user = Auth::guard('fan')->user(); 
            $objToken = $user->createToken('MyApp');
            $success['token'] = $objToken-> accessToken; 
            $expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now()); 
            return response()->json(['success' => $success,"expires_in" => $expiration], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'phone' => 'required', 
            'password' => 'required', 
            //'c_password' => 'required|same:password', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $hasBeen = Fan::where('phone',$request->phone)->first();
        if(empty($hasBeen)){
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = Fan::create($input); 

            $objToken = $user->createToken('MyApp');
            $success['token'] = $objToken-> accessToken; 
            $expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());
            

           // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            return response()->json(['success' => $success,"expires_in" => $expiration], $this-> successStatus);
           //return response()->json(['success'=>$success], $this-> successStatus); 
        }else{
            return response()->json(['error'=>'hasBeen'], 401);
        }
        
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::guard('api')->user();
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}