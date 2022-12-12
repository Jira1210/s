<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transfer_cash_Sadmin;
use App\Http\Helpers\Helper;

class TransferSadminController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        
        if ($user->hasRole(['Sadmin','admin'])) {

            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = transfer_cash_Sadmin::join('admins','admins.id', '=', 'transfer_cash__sadmins.admin_id')
            ->select('bank_name',
                     'bank_number',
                     'amount',
                     'info',
                     'transfer_cash__sadmins.created_at',
                     'transfer_cash__sadmins.status',
                     'admin_id',
                     )
            ->orderBy('id', 'desc')
            ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = transfer_cash_Sadmin::join('admins','admins.id', '=', 'transfer_cash__sadmins.admin_id')
                ->select('bank_name',
                     'bank_number',
                     'amount',
                     'info',
                     'transfer_cash__sadmins.created_at',
                     'transfer_cash__sadmins.status',
                     'admin_id',
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

    //------------------------------------------------------Create-----------------------------------------------------------
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin', 'admin'])) {
            
            $adminid = $user->id;

            $fields = $request->validate([
                'bank_name' => 'required',
                'bank_number' => 'required|numeric|max:50',
                'amount' =>'required|numeric',
                'info' => 'required',
           
            ]);
            
            //Create ------------------------------------------------
            $data = transfer_cash_Sadmin::create([
                'bank_name' => $fields['bank_name'],
                'bank_number' => $fields['bank_number'],
                'amount' => $fields['amount'],
                'info' => $fields['info'],
                'admin_id'=> $adminid,               
            ]);

            $response = [
                'transfer' => $data,                
            ];
            return response($response, 201);
            
        } else {
            Helper::sendError('Permission denied');
        }
    }
}
