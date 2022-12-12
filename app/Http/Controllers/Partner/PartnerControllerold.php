<?php

namespace App\Http\Controllers\Partner;
use App\Http\Controllers\Controller;
use App\Models\partner;
use App\Models\getpartner;
use App\Models\Partner_cash_detail;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function PartnerList(Request $request){
        $user = auth()->user();

    if ($user->hasRole(['Sadmin','admin'])) {
        $users = partner::all();
        return $users;
    } else {
        Helper::sendError('Permission denied');
    }
    }

    public function PartnerMember(Request $request){
        $user = auth()->user();

        if ($user->hasRole(['Sadmin','admin'])) {
            $users = getpartner::all();
            return $users;
        } else {
            Helper::sendError('Permission denied');
        }
    }

    public function PartnerCom(Request $request){
        $user = auth()->user();

        if ($user->hasRole(['Sadmin','admin'])) {
            $users = Partner_cash_detail::all();
            return $users;
        } else {
            Helper::sendError('Permission denied');
        }
    }
}
