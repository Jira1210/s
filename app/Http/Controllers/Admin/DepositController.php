<?php

namespace App\Http\Controllers\Admin;

use App\Models\deposit;
use App\Models\condition;
use App\Models\promotion;
use App\Models\activity;
use App\Models\user;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole(['Sadmin', 'admin'])) {

            $month = now()->month; //เดือนสำหรับแสดงข้อมูล
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = Deposit::join('gateways', 'gateways.id', '=', 'Deposits.gateway_id')
                ->join('admins', 'admins.id', '=', 'Deposits.admin_id')
                ->join('users', 'users.id', '=', 'Deposits.user_id')
                ->select(
                    'deposits.id',
                    'users.name',
                    'users.tel',
                    'banks.bank_name',
                    'users.bank_number',
                    'amount',
                    'datetime',
                    'status',
                    'type',
                )
                ->whereMonth('datetime', $month)
                ->orderBy('id', 'desc')
                ->paginate(3);

            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                $list = Deposit::join('gateways', 'gateways.id', '=', 'Deposits.gateway_id')
                    ->join('admins', 'admins.id', '=', 'Deposits.admin_id')
                    ->join('users', 'users.id', '=', 'Deposits.user_id')
                    ->select(
                        'deposits.id',
                        'users.name',
                        'users.tel',
                        'bank_name',
                        'bank_number',
                        'amount',
                        'datetime',
                        'status',
                        'type',
                    )
                    ->whereMonth('datetime', $month)
                    ->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('bank_name', 'like', '%' . $search . '%')
                    ->orWhere('bank_number', 'like', '%' . $search . '%')
                    ->orWhere('tel', 'like', '%' . $search . '%')
                    ->orWhere('deposits.status', 'like', '%' . $search . '%')
                    ->orWhere('datetime', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', $search)
                    ->orderBy('type', 'desc')
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

            $userdata = user::select('tel')->get();
            $adminid = $user->id;

            $fields = $request->validate([
                'tel' => 'required',
                'amount' => 'required',
                'datetime' => 'required',
                'gateway_id' => 'required',
                'type' => 'required',
            ]);

            //Create------------------------------------------------
            // $data = Deposit::create([
            //     'user_tel' => $fields['tel'],
            //     'amount' => $fields['amount'],
            //     'bonus' => $fields['tel'],
            //     'datetime' =>$fields['datetime'],
            //     'gateway_id' => $fields['gateway_id'],
            //     'type' => $fields['type'],
            //     // type 1 = รวมยอดฝาก  type 2 = ไม่รวมยอดฝาก type 3 = กิจกรรม+conditionID             
            //     'operator'=> $adminid,               
            // ]);
            //check condition --------------------------------------------
            if ($fields['type'] = 3) {
                $user = user::where('tel', '=', $fields['tel'])->get(); //รับไอดี

                if (count($user)) {
                    $userid = user::where('tel', '=', $fields['tel'])->first()->id;

                    $getpro = $request->getpro;
                    if (empty($getpro)) {
                        $getpro = '-';
                    } //ข้อมูลโปร
                    $getact = $request->getact;
                    if (empty($getact)) {
                        $getact = '-';
                    } //ข้อมูลกิจกรรม

                    $id = condition::all()->Contains('user_id', $userid);
                    $pro = condition::where('user_id', '=', $userid)->get()->Contains('promotion_id', $getpro);
                    $act = condition::where('user_id', '=', $userid)->get()->Contains('activity_id', $getact);
                    // $id ->contains('user_id',$userid);
                    // $pro ->contains('promotion_id',$getpro);
                    // $act ->contains('activity_id',$getact);
                    $response = ([$userid, $id, '-------------', $getpro, $pro, '--------------', $getact, $act]);
                    if ($id === true) {
                        if ($pro === true || $act === true) {
                            $response = 'เคยรับโปรโมชั่นหรือกิจกรรมนี้แล้ว';
                        } else {
                            $response = 'มีสิทธิ์';
                        }
                    }else{
                        $response = 'ยังไม่เคยรับโปรใดๆ';
                    }
                } else {
                    $response = 'ไม่มีชื่อผู้ใช้นี้';
                }
            }

            // $response = [
            //     'user' => $data,              
            // ];
            return response($response, 201);

            //Save-Log------------------------------------------------------------

        } else {
            Helper::sendError('Permission denied');
        }
    }
}
