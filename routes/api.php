<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CashbackController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\StatementInController;
use App\Http\Controllers\Admin\StatementOutController;
use App\Http\Controllers\Admin\TransferControlle;
use App\Http\Controllers\Admin\TransferSadminController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\WithdrawsController;

use App\Http\Controllers\Partner\PartnerController;

use App\Http\Controllers\User\GetfriendController;
use App\Http\Controllers\User\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//admin
Route::post('/admin-login',[AdminController::class,'AdminLogin']);
Route::post('/admin-register',[AdminController::class,'AdminRegister']);

Route::group(['middleware'=> ['auth:sanctum','abilities:admin']], function() {

    //----------------------------Admin----------------------------------------
    Route::post('/admin-detail',[AdminController::class,'AdminDetail']);
    Route::post('/admin-logout',[AdminController::class,'AdminLogout']);

    //----------------------------รายชื่อ-Admin----------------------------------
    Route::get('admin/admin-list',[AdminController::class,'AminList']);

    //----------------------------รายการเดินบัญชี----------------------------------
    Route::get('admin/statementIn-list',[StatementInController::class,'index']);
    Route::get('admin/statementout-list',[StatementOutController::class,'index']);

    //-------------------------------ฝาก----------------------------------------
    Route::get('admin/deposit-list',[DepositController::class,'index']);
    Route::get('admin/deposit',[DepositController::class,'store']);

    //--------------------------------ถอน--------------------------------------
    Route::get('admin/withdraw-list', [WithdrawsController::class,'index']);

     //--------------------------------โยกเงิน--------------------------------------
     Route::get('admin/tranfergame', [TransferControlle::class,'transfer_game']);
     Route::get('admin/tranfercash', [TransferControlle::class,'transfer_cash']);
     Route::get('admin/tranfercashSadmin', [TransferSadminController::class,'index']);

    //--------------------------------User--------------------------------------
    Route::get('admin/user-list',[AdminUserController::class,'index']);
    Route::post('admin/user-create',[AdminUserController::class,'store']);
    Route::post('admin/user-detail',[AdminUserController::class,'show']);
    Route::get('admin/user-edit',[AdminUserController::class,'update']);

    //--------------------------------Partner--------------------------------------
    Route::get('admin/partner-list',[PartnerController::class,'index']);
    Route::get('admin/partner-member',[PartnerController::class,'PartnerMember']);
    Route::get('admin/partner-com',[PartnerController::class,'PartnerCom']);
    
    //--------------------------------Cashback--------------------------------------
    Route::get('admin/cashback-list',[CashbackController::class,'CashbackList']);
    Route::get('admin/cashback-history',[CashbackController::class,'CashbackHistory']);
    
    
    //--------------------------------Friend-Zone-------------------------------------
    Route::get('admin/friend-list',[AdminGetfriendController::class,'FriendList']);
    Route::get('admin/friend-com',[AdminGetfriendController::class,'FriendCom']);

    
    //--------------------------------Promotion-------------------------------------
    Route::get('admin/promotion-list',[PromotionController::class,'index']);
    Route::get('admin/promotion-history',[PromotionController::class,'PromotionHistory']);


});

//user------------------------------------------------------------------------
Route::post('user-login',[UserController::class,'UserLogin']);
Route::post('user-register',[UserController::class,'UserRegister']);
Route::post('user-register/{key}',[UserController::class,'GetLink']);

Route::group(['middleware'=> ['auth:sanctum','abilities:user']],function(){

    
    Route::post('user-detail',[UserController::class,'UserDetail']);
    Route::post('user-logout',[UserController::class,'UserLogout']);

    Route::get('user/friend-list',[GetfriendController::class,'UFriendList']);
    Route::get('user/friend-com',[GetfriendController::class,'UFriendCom']);
    //Route::get('user/intive',[UserController::class,'flink']);
  



});