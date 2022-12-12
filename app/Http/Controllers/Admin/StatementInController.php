<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\statement_in;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;


class StatementInController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {

            $month=now()->month; //เดือนสำหรับแสดงข้อมูล
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา
            $list = statement_in::join('gateways','gateways.id', '=', 'statement_ins.gateway_id')
            ->select('statement_ins.id',
                     'bank_name',
                     'bank_number',
                     'amount',
                     'date_time',
                     'gateways.name',
                     'statement_ins.status',
                     )
            ->whereMonth('date_time',$month)
            ->orderBy('id', 'desc')
            ->paginate(3);
            
            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = statement_in::join('gateways','gateways.id', '=', 'statement_ins.gateway_id')
                ->select('statement_ins.id',
                         'bank_name',
                         'bank_number',
                         'amount',
                         'date_time',
                         'gateways.name',
                         'statement_ins.status',
                         )
                ->whereMonth('date_time',$month)
                ->where('bank_name','like','%'.$search.'%')
                ->orWhere('amount','=',$search)
                ->orWhere('date_time','like','%'.$search.'%')
                ->orwhere('bank_number','like','%'.$search.'%')
                ->orWhere('statement_ins.status','like','%'.$search.'%')
                ->orWhere('gateways.name','like','%'.$search.'%')
                ->paginate(1);//จำนวนรายการในหน้า
                 return  $list;
                }
                return $list;
        } else {
            Helper::sendError('Permission denied');
        }
    }
}
