<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Socialite;
use Exception;
use Auth;
use DB;

class FacebookController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->fields([
		            'name','first_name', 'last_name', 'email', 'gender', 'birthday','hometown','location','religion'
		        ])->scopes([
		            'email', 'user_birthday'
		        ])->redirect();
    }

    public function loginWithFacebook(){
    	try {
            $user = Socialite::driver('facebook')->fields(['name','first_name', 'last_name', 'email', 'gender', 'birthday','hometown','location','religion'])->user();
            $check = DB::table('users')->where('email',$user->email)->get();
            if($check->isEmpty()){
            	 $createUser = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make($user->name.'@123'),
                    'avatar' => $user->avatar,
                    // 'age' => $user->user['birthday'],
                    'fb_id' => $user->id
                ];
                $regisID = DB::table('users')->insertGetId($createUser);
                Auth::loginUsingId($regisID);
                return redirect('/dashboard/account');
            }else{
                if(empty($check[0]->google_id)){
                    DB::table('users')->where('email',$user->email)->update(['fb_id'=>$user->id]);
                }
            	Auth::loginUsingId($check[0]->id,true);
                return redirect('/dashboard/account');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    
}