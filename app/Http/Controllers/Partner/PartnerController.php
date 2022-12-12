<?php

namespace App\Http\Controllers\partner;

use App\Http\Controllers\Controller;
use App\Models\partner;
use App\Models\getpartner;
use App\Models\Partner_cash_detail;
use App\Models\Partner_cash;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin','admin'])) {

            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = partner::select('id',
                     'name',
                     'username',
                     'percent',
                     'status',
                     'partner_link',                   
                     'created_at',
                     )
                ->orderBy('id', 'desc')
                ->paginate(3);
            
                if (!empty($search)) {
                    $list = partner::select('id',
                    'name',
                    'username',
                    'percent',
                    'partner_link',                   
                    'status',
                    'created_at',
                    )
                    ->where('name','like','%'.$search.'%')
                    ->orWhere('username','like','%'.$search.'%')
                    ->orWhere('percent','like','%'.$search.'%')
                    ->orWhere('status','like','%'.$search.'%')
                    ->orWhere('partner_link','like','%'.$search.'%')
                    ->orWhere('created_at','like','%'.$search.'%')
                    ->orderBy('id', 'desc')
                    ->paginate(3);
                     return  $list;
                    }
                    return $list;

        } else {
            Helper::sendError('Permission denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function PartnerMember(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin','admin'])) {
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = getpartner::join('users','users.id', '=', 'Getpartners.user_id')
                ->join('partners','partners.id', '=', 'Getpartners.partner_id')
                ->select('Getpartners.id',
                     'partners.username',
                     'users.tel',
                     'Getpartners.status', 
                     'Getpartners.created_at',
                     )   
                ->orderBy('id', 'desc')
                ->paginate(3);
            
                if (!empty($search)) {
                    $list = getpartner::join('users','users.id', '=', 'Getpartners.user_id')
                        ->join('partners','partners.id', '=', 'Getpartners.partner_id')
                        ->select('Getpartners.id',
                         'partners.username',
                         'users.tel',
                         'Getpartners.status', 
                         'Getpartners.created_at',
                         ) 
                        ->where('partners.username','like','%'.$search.'%')
                        ->orWhere('users.tel','like','%'.$search.'%')
                        ->orWhere('Getpartners.status','like','%'.$search.'%')
                        ->orWhere('Getpartners.created_at','like','%'.$search.'%')
                        ->orderBy('id', 'desc')
                        ->paginate(3);
                     return  $list;
                    }
                    return $list;

        } else {
            Helper::sendError('Permission denied');
        }
    }
//--------------------------------------------------------------------------------------------------------------------------------
    public function PartnerCom(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin','admin'])) {
            $numlist = $request->numlist; //จำนวนรายการต่อหน้า    
            $search = $request->search; //คำค้นหา

            $list = Partner_cash::join('partner_cash_details','partner_cash_details.partner_cash_id', '=','partner_cashes.id')
                ->join('getpartners','getpartners.id', '=','partner_cash_details.getpartner_id')
                ->select(
                    'Partner_cashes.id',
                    'Getpartners.id',
                    'date_start',
                    'date_end',
                    'amount', 
                    'Partner_cashes.status',
                    'Partner_cashes.date_topay',
                     )   
                ->orderBy('id', 'desc')
                ->paginate(3);
            
                if (!empty($search)) {
                    $list = Partner_cash::join('partner_cash_details','partner_cash_details.partner_cash_id', '=','partner_cashes.id')
                    ->join('Getpartners','Getpartners.id', '=','partner_cash_details.getpartner_id')
                    ->select(
                         'Partner_cashes.id',
                         'Getpartners.id',
                         'date_start',
                         'date_end',
                         'amount',
                         'Partner_cashes.status',
                         'Partner_cashes.date_topay',
                         ) 
                        ->where('Getpartners.id','like','%'.$search.'%')
                        ->orWhere('date_start','like','%'.$search.'%')
                        ->orWhere('date_end','like','%'.$search.'%')
                        ->orWhere('Partner_cashes.status','like','%'.$search.'%')
                        ->orWhere('Partner_cashes.date_topay','like','%'.$search.'%')
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
