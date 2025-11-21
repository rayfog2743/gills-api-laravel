<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Carbon\Carbon;
class AuthController extends Controller
{
   public function register(Request $req){
      

    // dd($req->all());
        $validator=Validator::make($req->all(),[
            'name'=>'required|string|min:2|max:100',
            'email'=>'required|string|email|max:100|unique:users',
            'password'=>'required|min:6',
            'contact'=>'required|digits:10|unique:users,contact',
            // 'fcm_token'=>'required',
        ]);
    
        if($validator->fails()){
            return response()->json(
                [
                    'status'=>false,
                    'message'=> $validator->errors()->first(),
                ],
               200);
        }
    
        try{
            $code = substr(str_replace('.', '', microtime(true)), -8);

            $userresult=User::create([
                'name'=>$req->name,
                'email'=>$req->email,
                'password'=>Hash::make($req->password),
                'contact'=>$req->contact,
                'role'=>'user',
                // 'saas_id'=>env('SAAS_KEY'),
                // 'role'=>'Manager',
            ]);

            $token = JWTAuth::fromUser($userresult); // Generate JWT token for the new user

            $refreshToken = Str::random(60);
            $userresult->refresh_token = hash('sha256', $refreshToken);
            // $userresult->device_fcm_token = $req->fcm_token;
            $userresult->save();

        
            $role = $userresult->role;
        
          
              
             
             
              

            return response()->json([
                'status'=>true,
                'access_token' => $token,
                'refresh_token' => $refreshToken,
                'token_type' => 'bearer',
            
                'expires_in' => auth()->factory()->getTTL() * 60,
                // 'Fcm_Notification_response' => $response 
            ]);




             

        
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message' =>$e->getMessage(),
                
                
            ]);
        }

       
       
    }

    
     public function userlogin(Request $req)
    {
        // ✅ Validate request
        $validator = Validator::make($req->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        // Determine login field (email or contact)
        $loginField = filter_var($req->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'contact';

        $credentials = [
            $loginField => $req->username,
            'password'  => $req->password
        ];

        try {
            // Attempt login
            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid Username or Password',
                ], 200);
            }

            $user = auth()->user();
            $role = $user->role ?? null;

            if($role!='user'){
                return response()->json([
                    'status'  => false,
                    'message' => 'Your not User Access',
                ], 200);
            }

            // Generate refresh token
            $refreshToken = Str::random(60);
            $user->refresh_token = hash('sha256', $refreshToken);
            $user->save();

            // Calculate token expiry safely
            $ttlMinutes = (int) env('JWT_TTL', 14400); // default 10 days
            $expiresAt = Carbon::now()->addMinutes($ttlMinutes)->toDateTimeString();

            return response()->json([
                'status'        => true,
                'access_token'  => $token,
                'refresh_token' => $refreshToken,
                'token_type'    => 'bearer',
                'name'          => $user->name,
                'expires_at'    => $expiresAt
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500); // better to return 500 for exceptions
        }
    }

      public function adminlogin(Request $req)
    {
        // ✅ Validate request
        $validator = Validator::make($req->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        // Determine login field (email or contact)
        $loginField = filter_var($req->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'contact';

        $credentials = [
            $loginField => $req->username,
            'password'  => $req->password
        ];

        try {
            // Attempt login
            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid Username or Password',
                ], 200);
            }

            $user = auth()->user();
            $role = $user->role ?? null;

            // dd( $role );
            if($role!='admin'){
                   return response()->json([
                    'status'  => false,
                    'message' => 'Your Not Admin',
                ], 200);
            }

            // Generate refresh token
            $refreshToken = Str::random(60);
            $user->refresh_token = hash('sha256', $refreshToken);
            $user->save();

            // Calculate token expiry safely
            $ttlMinutes = (int) env('JWT_TTL', 14400); // default 10 days
            $expiresAt = Carbon::now()->addMinutes($ttlMinutes)->toDateTimeString();

            return response()->json([
                'status'        => true,
                'access_token'  => $token,
                'refresh_token' => $refreshToken,
                'token_type'    => 'bearer',
                'name'          => $user->name,
                'expires_at'    => $expiresAt
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500); // better to return 500 for exceptions
        }
    }
}
