<?php

namespace App\Http\Controllers\Admin;
use App\Models\withdraws;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class WithdrawsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {           

            $month=now()->month; //เดือนสำหรับแสดงข้อมูล
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = withdraws::join('gateways','gateways.id', '=', 'withdraws.gateway_id')
            ->join('admins','admins.id', '=', 'withdraws.admin_id')
            ->join('conditions','conditions.id', '=', 'withdraws.condition_id')
            ->join('users','users.id', '=', 'withdraws.user_id')
            ->select('withdraws.id',
                     'name',
                     'tel',
                     'bank_name',
                     'bank_number',
                     'amount',
                     'datetime',
                     'withdraws.status',
                     'type',
                     )
            ->whereMonth('datetime',$month)
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = withdraws::join('gateways','gateways.id', '=', 'withdraws.gateway_id')
                ->join('admins','admins.id', '=', 'withdraws.admin_id')
                ->join('conditions','conditions.id', '=', 'withdraws.condition_id')
                ->join('users','users.id', '=', 'withdraws.user_id')
                ->join('banks','banks.id', '=', 'users.bank_id')
                ->select('withdraws.id',
                         'name',
                         'tel',
                         'bank_name',
                         'bank_number',
                         'amount',
                         'datetime',
                         'withdraws.status',
                         'type',
                         )
                ->whereMonth('datetime',$month)
                ->where('users.name','like','%'.$search.'%')
                ->orWhere('banks.bank_name','like','%'.$search.'%')
                ->orWhere('users.bank_number','like','%'.$search.'%')
                ->orWhere('users.tel','like','%'.$search.'%')
                ->orWhere('withdraws.status','like','%'.$search.'%')
                ->orWhere('datetime','like','%'.$search.'%')
                ->orWhere('amount','like',$search)
                ->orderBy('type', 'desc')
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
