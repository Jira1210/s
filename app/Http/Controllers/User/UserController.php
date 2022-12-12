<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Models\getfriend;
use App\Models\Login_log_user;


class UserController extends Controller
{
    //sublink-----------------------------------------------------
    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    //-------------------------------------------------cookie--------------------------------------------------
    public function GetLink(Request $request, $key)
    {
        //getlink
        $key = $request->key;
        Cookie::queue('cookie_key', $key, 10080);
        $code = Cookie::get('cookie_key');
        return ([$code, $key]);
    }


    //-------------------------------------------------Register--------------------------------------------------
    public function UserRegister(Request $request)
    {
        //validate field---------------------------------------------
        $fields = $request->validate([
            'tel' => 'required|unique:users,tel|string|min:10|max:10',
            'name' => 'required|string|max:50',
            'password' => 'required|string|confirmed|min:6',
            'bank_id' => 'required|Integer',
            'bank_number' => 'required',
            'line' => 'required|string',
            'reference_id' => 'Integer|required',
        ]);

        //Create users------------------------------------------------
        $user = User::create([
            'tel' => $fields['tel'],
            'name' => $fields['name'],
            'password' => bcrypt($fields['password']),
            'bank_id' => $fields['bank_id'],
            'bank_number' => $fields['bank_number'],
            'line' => $fields['line'],
            'reference_id' => $fields['reference_id'],
        ]);

        //create tooken-----------------------------------------------
        $token = $user->createToken($request->userAgent(), ['user'])->plainTextToken;


        //createlink--------------------------------------------------
        $dataid = User::where('tel', '=', $fields['tel'])->first('id');
        $id = (int)$this->get_string_between($dataid , ':', '}');
        $num = mt_rand(001, 999);
        $fcode = 'Friend' . $id . 'd1' . $num;

        //get .env  app_url
        //getenv('app.name')
        $furl = config('app.name').'/api/user-register/' . $fcode;
        user::where('tel', $fields['tel'])->update(['friend_link' => $furl]);

        

        //getfriend-----------------------------------------------------
        //--1.-ไอดีคนถูกเชิญ----
        $datachilid = User::where('tel', '=', $fields['tel'])->first('id');
        $child_id = (int) $this->get_string_between($datachilid, ':', '}');
        //--2.--ไอดีคนเชิญ---
        $cookiekey = Cookie::get('cookie_key');
        $parrent_id = (int) $this->get_string_between($cookiekey, 'Friend', 'd1');
        //--3.--เพิ่มข้อมูล----
        if ($cookiekey) {
             getfriend::create([
                'user_child_id'=>$child_id,
                'user_parent_id'=>$parrent_id]);
        }
        //ตอบกลับ--------------------------------------------------------
        $response = [
            'user' => $user,
            'url' => $furl,
            'token' => $token,
            'cookie' => $cookiekey,
            'parrent' => $parrent_id,
            'child' => $child_id,
            'token' => $token
        ];
        return response($response, 201);
    }
    //-------------------------------------------------login-----------------------------------------------------
    public function UserLogin(Request $request)
    {
        //validate field------------------------------------------------
        $input = $request->all();
        $validation = Validator::make($input, [
            'tel' => 'required|string|min:10|max:10',
            'password' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response(['error' => $validation->errors()], 422);
        }

        //Checkdata 
        $user = User::where('tel', $input['tel'])->first();
        if (!$user || !Hash::check($input['password'], $user->password)) {
            return response([
                'message' => 'หมายเลขโทรศัพท์หรือรหัสผ่านไม่ถูกต้อง'
            ]);
        } else {
            if (Auth::guard('user')->attempt([
                'tel' => $input['tel'],
                'password' => $input['password']
            ])) { 
                $status=User::where('tel','=',$input['tel'])->first(); 
                      
                if($status->status == 2){
                    return response([
                        'message' => 'คุณถูกระงับการใช้งาน โปรดติดต่อแอดมิน',
                    ]);
                }else{

                    $user->tokens()->delete();
                    $user = Auth::guard('user')->user();
                    $token = $user->createToken($request->userAgent(), ['user'])->plainTextToken;
                    user::where('tel','=',$input['tel'])->update(['last_login' => now()]);
    
                    //login log---------------------------------------
                    $dataid = User::where('tel', '=', $input['tel'])->first('id');
                    $id = (int)$this->get_string_between($dataid , ':', '}');
                    $ip= request()->ip();
                    $device= request()->userAgent();
                    Login_log_user::create(['user_id' =>  $id,'device'=>$device,'ip_address'=>$ip]);
                    return response(['token' => $token, 'Status'=>$status,]); 
                }
            }
        }
    }


    //----------------------------------------------detail-------------------------------------------------
    public function UserDetail()
    {
        $user = auth::user();
        return response(['data' => $user]);
    }
    //---------------------------------------------logout-------------------------------------------------
    public function UserLogout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'logouted'
        ];
    }

   
}
