<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\getfriend;
use App\Models\friend_cashs_detail;
use App\Http\Helpers\Helper;

class AdminGetfriendController extends Controller
{
    //-----------------------------------------------Admin-----------------------------------------
    //------------------List----------------------
    public function FriendList(Request $request){

        $user = auth()->user();
    if ($user->hasRole(['Sadmin','admin'])) {

            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = getfriend::join('users AS child','child.id', '=', 'getfriends.user_child_id')
                ->join('users AS parent','parent.id', '=', 'getfriends.user_parent_id')
                ->select(
                     'getfriends.id',
                     'child.tel', 
                     'parent.tel', 
                     'getfriends.status',
                     )
                ->orderBy('id', 'desc')
                ->paginate(3);
            
                if (!empty($search)) {
                    $list = getfriend::join('users AS child','child.id', '=', 'getfriends.user_child_id')
                    ->join('users AS parent','parent.id', '=', 'getfriends.user_parent_id')
                    ->select(
                         'getfriends.id',
                         'child.tel', 
                         'parent.tel', 
                         'getfriends.status',
                         )
                        ->where('getfriends.id','like','%'.$search.'%')
                        ->orWhere('child.tel','like','%'.$search.'%')
                        ->orWhere('parent.tel','like','%'.$search.'%')
                        ->orWhere('getfriends.status','like','%'.$search.'%')
                        ->orderBy('id', 'desc')
                        ->paginate(3);
                     return  $list;
                    }
                    return $list;
    } else {
        Helper::sendError('Permission denied');
    }
    }

    //---------------Commission------------------
    public function FriendCom(Request $request){
        
        $user = auth()->user();

    if ($user->Auth::guard('user')) {
        $users = friend_cashs_detail::all();
        return $users;
    } else {
        Helper::sendError('Permission denied');
    }
    }
}
