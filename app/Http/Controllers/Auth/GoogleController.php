<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Socialite;
use Exception;
use Auth;
use DB;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
    
            $user = Socialite::driver('google')->user();
            $check = DB::table('users')->where('email',$user->email)->get();
            if($check->isEmpty()){
                $createUser = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make($user->user['given_name'].'@123'),
                    'avatar' => $user->avatar,
                    // 'age' => '',
                    'google_id' => $user->id
                ];
                $regisID = DB::table('users')->insertGetId($createUser);
                Auth::loginUsingId($regisID);
                return redirect('/dashboard/account');
            }else{
                if(empty($check[0]->google_id)){
                    DB::table('users')->where('email',$user->email)->update(['google_id'=>$user->id]);
                }
                Auth::loginUsingId($check[0]->id,true);
                return redirect('/dashboard/account');
            }
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}