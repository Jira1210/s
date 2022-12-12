<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\getfriend;
use App\Models\friend_cashs_detail;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;


class GetfriendController extends Controller
{
    

    //-----------------------------------------------user----------------------------------------
    
    //------------------List----------------------
    public function UFriendList(Request $request){
        $user = auth()->user();

        if ($user->Auth::guard('user')) {
            
            $id= auth()->user()->id;
            $myfriend = getfriend::join('users', 'users.id', '=', 'user_child_id')
            //->join('friend_cashs_details','friend_cashs_details.id', '=', 'getfriend_id')
            ->select('users.name')
            ->where('user_parent_id','=',$id)
            ->get();
            return (['ID'=>$id,
            'data'=>$myfriend]); 

        } else {
            Helper::sendError('Permission denied');
        }
    }

    //---------------Commission------------------
    public function UFriendCom(Request $request){
        $user = auth()->user();

    if ($user->hasRole(['Sadmin','admin'])) {
        $users = friend_cashs_detail::all()->where('');
        return $users;
    } else {
        Helper::sendError('Permission denied');
    }
    }
}
