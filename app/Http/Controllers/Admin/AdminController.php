<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    

//-------------------------------------------------Register--------------------------------------------------
    public function AdminRegister(Request $request)
    {
         //validate field
         $fields = $request->validate([
            'username'=>'required|unique:admins,username|string',
            'password'=>'required|string|confirmed|min:6',
            'name'=>'required|string|max:50',
            'role_id'=>'required|integer',
                        
        ]);
        //Create users
        $admin =admin::create([
            'username'=>$fields['username'],
            'password'=> bcrypt($fields['password']),
            'name'=>$fields['name'],
            'role_id'=>$fields['role_id'],          
        ]);
        
                
        //create tooken
        
        $token = $admin ->createToken($request->userAgent(), ['admin'])->plainTextToken;
                 
        $response=[
            'user'=>$admin ,
            'token'=>$token,           
        ];
        return response($response,201);
    }
    //-------------------------------------------------login-----------------------------------------------------
    public function AdminLogin(Request $request){
            
        //validate field
        $input=$request->all();
            $validation = Validator::make($input,[  
                'username'=>'required|string',
                'password'=>'required|string',
            ]);

            if ($validation->fails()){
                return response(['error'=>$validation->errors()],422);
            }

            //Checkdata 
            $user=Admin::where('username',$input['username'])->first();
            if(!$user || !Hash::check($input['password'],$user->password)){
             return response([
                 'message'=>'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
             ]);
            }else
            {
             if(Auth::guard('admin')->attempt([
                    'username'=>$input['username'],
                    'password'=>$input['password']
                ])){
                    
                    $user->tokens()->delete();
                    $user = Auth::guard('admin')->user();
                    $token = $user->createToken($request->userAgent(), ['admin'])->plainTextToken;
                    return response(['token'=>$token,]);
                }
            }
        }
         //-------------------------------------------------detail-------------------------------------------------
        public function AdminDetail(){
            
            
            $user=auth::user();
            return response(['data'=>$user]);

        }

        //-------------------------------------------------logout-------------------------------------------------
        public function AdminLogout(Request $request){
            auth()->user()->tokens()->delete();
            return [
                'message' => 'logouted'
            ];
            
        }

        //-------------------------------------------------AdminList-------------------------------------------------
        public function AminList(Request $request){
            $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            $users = Admin::all();
            return $users;
        } else {
            Helper::sendError('Permission denied');
        }
        }
         //-------------------------------------------------UserList-------------------------------------------------
        public function UserList(Request $request)
        {
            $user = auth()->user();
            if ($user->hasRole(['Sadmin', 'admin'])) {
                $users = User::all();
                return $users;
            } else {
                Helper::sendError('Permission denied');
            }
        }

        //-------------------------------------------------UserRegister-By-Admin-----------------------------------------------
        public function UserRegister(Request $request)
    {
       
        
        $user = auth()->user();
            if ($user->hasRole(['Sadmin', 'admin'])) {
            
                $fields = $request->validate([
                    'tel' => 'required|unique:users,tel|string|min:10|max:10',
                    'name' => 'required|string|max:50',
                    'password' => 'required|string|min:6',
                    'bank_id' => 'required|Integer',
                    'bank_number' => 'required',
                ]);
                $num = mt_rand(001, 999);
                $pass = 'Us' .$num;
                $userid = $user->id;
                //Create users------------------------------------------------
                $user = User::create([
                    'tel' => $fields['tel'],
                    'name' => $fields['name'],
                    'password' => bcrypt($pass),
                    'bank_id' => $fields['bank_id'],
                    'bank_number' => $fields['bank_number'],
                    'admin_id'=> $userid
                ]);
                $response = [
                    'user' => $user,
                    'password' => $pass                   
                ];
                return response($response, 201);
            } else {
                Helper::sendError('Permission denied');
            }
        }
}
