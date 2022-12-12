<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminUserControllerold extends Controller
{
     //-------------------------------------------------UserList-------------------------------------------------
    public function UserList(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin', 'admin'])) {
            return User::all();           
        } else {
            Helper::sendError('Permission denied');
        }
    }

    //-------------------------------------------------UserRegister-By-Admin-----------------------------------------------

     
}
