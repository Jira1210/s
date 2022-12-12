<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\cashback;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;

class CashbackController extends Controller
{
    public function cashbackList(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {         
            
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = cashback::join('Cashback_details','Cashback_details.cashback_id', '=', 'cashbacks.id')
                ->join('Type_cashbacks','Type_cashbacks.id', '=', 'Cashback_details.type_cashback_id')
                ->join('users','users.id', '=', 'Cashback_details.user_id')
                ->select('cashbacks.id',
                     'users.tel',
                     'date_start',
                     'date_end',
                     'cashbacks.amount',
                     'date_topay',                   
                     'cashbacks.status',
                     )         
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = cashback::join('Cashback_details','Cashback_details.cashback_id', '=', 'cashbacks.id')
                ->join('Type_cashbacks','Type_cashbacks.id', '=', 'Cashback_details.type_cashback_id')
                ->join('users','users.id', '=', 'Cashback_details.user_id')
                ->select('cashbacks.id',
                     'tel',
                     'users.name',
                     'date_start',
                     'date_end',
                     'cashbacks.amount',
                     'date_topay',                   
                     'cashbacks.status',
                     )
                ->where('cashbacks.status','=',2)
                ->orWhere('users.name','like','%'.$search.'%')
                ->orWhere('tel','like','%'.$search.'%')
                ->orWhere('date_start','like','%'.$search.'%')
                ->orWhere('date_end','like','%'.$search.'%')
                ->orWhere('cashbacks.amount','like','%'.$search.'%')
                ->orWhere('date_topay','like','%'.$search.'%')
                ->orderBy('id','desc')
                ->paginate(3);
                 return  $list;
                }
                return $list;
        } else {
            Helper::sendError('Permission denied');
        }
    }

    public function cashbackHistory(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {

            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา
            $list = cashback::join('Cashback_details','Cashback_details.cashback_id', '=', 'cashbacks.id')
                ->join('Type_cashbacks','Type_cashbacks.id', '=', 'Cashback_details.type_cashback_id')
                ->join('users','users.id', '=', 'Cashback_details.user_id')
                ->select('cashbacks.id',
                     'users.tel',
                     'date_start',
                     'date_end',
                     'cashbacks.amount',
                     'date_topay',                   
                     'cashbacks.status',
                     )
            ->where('cashbacks.status','=',2)
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = cashback::join('Cashback_details','Cashback_details.cashback_id', '=', 'cashbacks.id')
                ->join('Type_cashbacks','Type_cashbacks.id', '=', 'Cashback_details.type_cashback_id')
                ->join('users','users.id', '=', 'Cashback_details.user_id')
                ->select('cashbacks.id',
                     'users.tel',
                     'date_start',
                     'date_end',
                     'cashbacks.amount',
                     'date_topay',                   
                     'cashbacks.status',
                     )
                     ->where('cashbacks.status','=',2)
                     ->orWhere('users.name','like','%'.$search.'%')
                     ->orWhere('tel','like','%'.$search.'%')
                     ->orWhere('date_start','like','%'.$search.'%')
                     ->orWhere('date_end','like','%'.$search.'%')
                     ->orWhere('cashbacks.amount','like','%'.$search.'%')
                     ->orWhere('date_topay','like','%'.$search.'%')
                     ->orderBy('id','desc')
                     ->paginate(3);
                     return  $list;
                }
                return $list;
            } else {
            Helper::sendError('Permission denied');
            }
        }
}
