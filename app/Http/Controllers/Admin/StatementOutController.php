<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\statement_out;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;

class StatementOutController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {

            $month=now()->month; //เดือนสำหรับแสดงข้อมูล
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา
            $list = statement_out::join('gateways','gateways.id', '=', 'statement_outs.gateway_id')
            ->select('statement_outs.id',
                     'bank_name',
                     'bank_number',
                     'amount',
                     'date_time',
                     'gateways.name',
                     )
            ->whereMonth('date_time',$month)
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = statement_out::join('gateways','gateways.id', '=', 'statement_outs.gateway_id')
                ->select('statement_outs.id',
                         'bank_name',
                         'bank_number',
                         'amount',
                         'date_time',
                         'gateways.name',
                         )
                ->whereMonth('date_time',$month)
                ->where('bank_name','like','%'.$search.'%')
                ->orwhere('bank_number','like','%'.$search.'%')
                ->orWhere('amount','=',$search)
                ->orWhere('date_time','like','%'.$search.'%')
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
