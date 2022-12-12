<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\promotion;

class PromotionController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {
           
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = promotion::join('Conditions','promotion_id', '=', 'promotions.id')
            ->join('users','users.id', '=', 'Conditions.user_id')
            ->join('banks','banks.id', '=', 'users.bank_id')
            ->select('promotions.id',
                     'users.name',
                     'users.tel',
                     'banks.bank_name',
                     'users.bank_number',
                     'promotions.name',
                     'type',
                     'Conditions.status',                   
                     'Conditions.updated_at',
                     )
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = promotion::join('Conditions','promotion_id', '=', 'promotions.id')
                ->join('users','users.id', '=', 'Conditions.user_id')
                ->join('banks','banks.id', '=', 'users.bank_id')
                ->select('promotions.id',
                     'users.name',
                     'tel',
                     'banks.bank_name',
                     'users.bank_number',
                     'promotions.name',
                     'type',
                     'Conditions.status',                   
                     'Conditions.updated_at',
                     )
                 ->where('users.name','like','%'.$search.'%')
                ->orWhere('bank_name','like','%'.$search.'%')
                ->orWhere('bank_number','like','%'.$search.'%')
                ->orWhere('tel','like','%'.$search.'%')
                ->orWhere('Conditions.status','%'.$search.'%')
                ->orWhere('Conditions.updated_at','like','%'.$search.'%')
                ->orderBy('id', 'desc')
                ->paginate(3);
                 return  $list;
                }
                return $list;
        } else {
            Helper::sendError('Permission denied');
        }
    }

    public function PromotionHistory(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {
          
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = promotion::join('Conditions','promotion_id', '=', 'promotions.id')
                ->join('users','users.id', '=', 'Conditions.user_id')
                ->join('banks','banks.id', '=', 'users.bank_id')
                ->select('promotions.id',
                     'users.tel',
                     'banks.bank_name',
                     'users.bank_number',
                     'promotions.name',
                     'type',
                     'Conditions.status',                   
                     'Conditions.updated_at',
                     )
            ->where('Conditions.status','=',2)
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = promotion::join('Conditions','promotion_id', '=', 'promotions.id')
                ->join('users','users.id', '=', 'Conditions.user_id')
                ->join('banks','banks.id', '=', 'users.bank_id')
                ->select('promotions.id',
                     'users.name',
                     'users.tel',
                     'banks.bank_name',
                     'users.bank_number',
                     'promotions.name',
                     'type',
                     'Conditions.status',                   
                     'Conditions.created_at',
                     )
                ->where('Conditions.status','=',2)
                ->orwhere('users.name','like','%'.$search.'%')
                ->orWhere('bank_name','like','%'.$search.'%')
                ->orWhere('bank_number','like','%'.$search.'%')
                ->orWhere('tel','like','%'.$search.'%')
                ->orWhere('Conditions.status','like','%'.$search.'%')
                ->orWhere('Conditions.created_at','like','%'.$search.'%')
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
