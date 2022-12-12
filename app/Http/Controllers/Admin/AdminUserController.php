<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Controllers\Admin\withPath;
use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use App\Models\User;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //------------------------------------------------------index-----------------------------------------------------------
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin', 'admin'])) {

            $numlist = $request->numlist;      
            $search = $request->search;
            $list = User::join('banks','banks.id', '=', 'users.bank_id')
            ->select('users.id',
                     'name',
                     'tel',
                     'banks.bank_name',
                     'bank_number',
                     'status',
                     'users.created_at'
                     )
            ->orderBy('id', 'desc')
            ->paginate(3);
            
            //ค้นหา-----------------------------------------
            if (!empty($search)) {
                // $collection = $list->filter(function ($item) use ($search) {
                //     return false !== stripos($item, $search);
                // });
                // $passed = $list->filter(function ($value, $search) {
                //     data_get($value, 'users.id') > 70;
                // });

                $list = User::join('banks','banks.id', '=', 'users.bank_id')
                ->select('users.id',
                         'name',
                         'tel',
                         'banks.bank_name',
                         'bank_number',
                         'status',
                         'users.created_at'
                         )
                ->where('name','like','%'.$search.'%')
                ->orWhere('bank_number','like','%'.$search.'%')
                ->orWhere('tel','like','%'.$search.'%')
                ->orWhere('banks.bank_name','like','%'.$search.'%')
                ->orWhere('status','like','%'.$search.'%')
                ->orderBy('id', 'desc')
                ->paginate(1);//จำนวนรายการในหน้า
                 //$page->withPath('/admin/user-list');
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
    //------------------------------------------------------Create-----------------------------------------------------------
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(['Sadmin', 'admin'])) {
            
            $num = mt_rand(001, 999);
            $pass = 'w01' .$num;
            $adminid = $user->id;
            
            $fields = $request->validate([
                'tel' => 'required|unique:users,tel|numeric|min:10|max:10',
                'name' => 'required|string|max:50',
                'password' =>'required|string',
                'bank_id' => 'required|Integer',
                'bank_number' => 'required',
            
            ]);
            
            //Create users------------------------------------------------
            $user = User::create([
                'tel' => $fields['tel'],
                'name' => $fields['name'],
                'password' => bcrypt($pass),
                'bank_id' => $fields['bank_id'],
                'bank_number' => $fields['bank_number'],
                'admin_id'=> $adminid,               
            ]);

            //createlink--------------------------------------------------
            $dataid = User::where('tel', '=', $fields['tel'])->get('id');
            $ndtel = (int)substr($dataid, 7, 2);
            $num = mt_rand(001, 999);
            $fcode = 'Friend' . $ndtel . 'd1' . $num;
            //get .env  app_url
            $furl = config('app.url').'/api/user-register/' . $fcode;
            user::where('tel', $fields['tel'])->update(['friend_link' => $furl]);

            $response = [
                'user' => $user,
                'password' => $pass                   
            ];
            return response($response, 201);

            //Save-Log------------------------------------------------------------
            
        } else {
            Helper::sendError('Permission denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //-----------------------------------------------------Detail---------------------------------------------------------
    public function show($id)
    {
      
        $user = auth()->user(); 
        if ($user->hasRole(['Sadmin', 'admin'])) {
       
        $data=User::find($id)
                     ->join('banks', 'bank.id', '=', 'users.bank_id')
                     ->select('users.*','banks.bank_name','bank_number');
                     
        return $data;
        } else {
            Helper::sendError('Permission denied');
        }
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
    //------------------------------------------------------update-----------------------------------------------------------
    public function update(Request $request, $id)
    {
        $user = auth()->user(); 
        if ($user->hasRole(['Sadmin', 'admin'])) {
        $adminid = $user->id;
        
        // $fields = $request->validate([
        //     'name' => 'string|max:50',
        //     'tel' => 'numeric|unique:users,tel|min:10|max:10',
        //     'bank_id' => 'Integer',
        //     'bank_number' => 'numeric',
        //     'status'       
        // ]);
        
        $userupdate = User::find($id);
        $userupdate->name = $request->name;
        $userupdate->phone = $request->phone;
        $userupdate->bank_id = $request->bank_id;
        $userupdate->bank_number = $request->bank_number;
        $userupdate->status = $request->status;
        if (!empty($request->password)) {
            $userupdate->password = bcrypt($request->password);
        }
        $userupdate->update($userupdate->all());
        
        } else {
         Helper::sendError('Permission denied');
        }
           
        
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


 
}
