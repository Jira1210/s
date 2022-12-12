<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transfer_game;
use App\Models\transfer_cash;
use App\Http\Helpers\Helper;


class TransferControlle extends Controller
{
    public function transfer_game(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {

            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = transfer_game::join('users','users.id', '=', 'transfer_games.user_id')
            ->select('transfer_games.id',
                     'users.tel',
                     'credit_before',
                     'credit',
                     'credit_after',
                     'type',
                     'transfer_games.status',                   
                     'transfer_games.created_at',
                     )
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = transfer_game::join('users','users.id', '=', 'transfer_games.user_id')
                ->select('transfer_games.id',
                         'users.tel',
                         'credit_before',
                         'credit',
                         'credit_after',
                         'type',
                         'transfer_games.status',                   
                         'transfer_games.created_at',
                         )
                
                ->orderBy('id', 'desc')
                ->paginate(3);
                 return  $list;
                }
                return $list;
        } else {
            Helper::sendError('Permission denied');
        }
    }
    //----------------------------------------------------------------------------------------------------
    public function transfer_cash(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {

                     $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = transfer_cash::join('users','users.id', '=', 'transfer_cashes.user_id')
            ->select('transfer_games.id',
                     'users.tel',
                     'credit_before',
                     'credit',
                     'credit_after',
                     'type',
                     'transfer_games.status',                   
                     'transfer_games.created_at',
                     )
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = transfer_cash::join('users','users.id', '=', 'transfer_cashes.user_id')
                ->select('transfer_games.id',
                         'users.tel',
                         'credit_before',
                         'credit',
                         'credit_after',
                         'type',
                         'transfer_games.status',                   
                         'transfer_games.created_at',
                         )
                ->orderBy('id', 'desc')
                ->paginate(3);
                 return  $list;
                }
                return $list;
        } else {
            Helper::sendError('Permission denied');
        }
    }
}
