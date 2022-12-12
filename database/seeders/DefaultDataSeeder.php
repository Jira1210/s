<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Agent_game;
use App\Models\Bank;
use App\Models\Gateway;
use App\Models\Referencetb;
use App\Models\Setting_level;
use App\Models\Setting_website;;
use App\Models\type_bank;
use App\Models\type_friend_commission;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // ---------------------------permission---------------------------------------
    $create = Permission::create(['name' => 'create']);
    $view = Permission::create([ 'name' => 'view']);
    $edit = Permission::create(['name' => 'edit']);
    $delete = Permission::create([ 'name' => 'delete ']);
   
   
    //--------------------------------Data----------------------------------------------
    
    //-------------------Type Bank-----------------
    $tbank1['typebank_name']='ธนาคาร';
    type_bank::create($tbank1);
        
    $tbank2['typebank_name']='กระเป๋าเงินดิจิทัล';
    type_bank::create($tbank2);

    //-------------------Bank----------------------
    $bank1['bank_name']='ธนาคารกสิกรไทย';
    $bank1['typebank_id']=1;
    $bank1['bank_logo']='K.png';
    Bank::create($bank1);
        
    $bank2['bank_name']='ทรูวอลเล็ต';
    $bank2['typebank_id']=2;
    $bank2['bank_logo']='t.png';
    Bank::create($bank2);

    //--------------------ref----------------------
    $ref1['name']='Google';
    Referencetb::create($ref1);
   
    $ref2['name']='Facebook';
    Referencetb::create($ref2);
    
    //--------------setting_level_id----------------
    $setlevel1['name']='Level1';
    $setlevel1['cashback_percent']=0.03;
    $setlevel1['friend_percent']=0.03;
    Setting_level::create($setlevel1);
   
    $setlevel2['name']='Level2';
    $setlevel2['cashback_percent']=0.05;
    $setlevel2['friend_percent']=0.05;
    Setting_level::create($setlevel2);
    
    //--------------setting-WEB---------------
    $setweb1['title']='A WEB';
    $setweb1['detail']='A WEB...';
    $setweb1['notify']='ABC';
    $setweb1['line']='Aweline';
    $setweb1['turnover_clear']=100;
    $setweb1['friend_default']=100;
    $setweb1['cashback_default']=100;
    Setting_website::create($setweb1);


    //-------------------User---------------------
    $udata['tel']='0815854321';
    $udata['name']='A';
    $udata['password']=bcrypt('password');
    $udata['Bank_id']=1;
    $udata['Bank_number']=123456789;
    $udata['line']='A1';  
    $udata['reference_id']=1;  
    $udata['friend_link']=1;  
    $udata['setting_id']=1;  
    User::create($udata);
    

    //-------type_friend_commission-----------------
    $tfriendcom1['name']='cashback';
    $tfriendcom1['detail']='...';  
    type_friend_commission::create($tfriendcom1);
    
    $tfriendcom2['name']='Turn over';
    $tfriendcom2['detail']='...';  
    type_friend_commission::create($tfriendcom2);

    //-------------------Agent---------------------
    $agent['name']='Bet Flik';
    $agent['user_agent_main']='cashback';
    $agent['status']=1;
    Agent::create($agent);
    
    //----------------Agent-Game-------------------
    $agentg['game_name']='Slot';
    $agentg['provider']='PG';
    $agentg['agent_id']=1;
    $agentg['game_code']='PG001';
    $agentg['status']=1;
    Agent_game::create($agentg);

    //----------------Gate-Way-----------------------
    $g1['name']='ธนาคารไทยพาณิชย์ (SCB)';
    $g1['status']='1';
    Gateway::create($g1);

    
    $g2['name']='ธนาคารกสิกรไทย (KBank)';
    $g2['status']='1';
    Gateway::create($g2);
    
    $g3['name']='ทรูมันนี่วอลเล็ท (TrueMoney Wallet)';
    $g3['status']='1';
    Gateway::create($g3);





    //--------------------------------Set-role-admin---------------------------------------
    $role1=Role::create(['name'=>'admin','guard_name' => 'admin']);
    $role1->givePermissionTo([
        $view,
        $create,
        $edit,
    ]);

    $admin =Admin::create([
        'username'=>'admin001',
        'password'=> bcrypt('password'),
        'name'=>'A',
        'role_id'=>'1'
    ]);  
    
    $admin->assignRole($role1);
    $admin->givePermissionTo([
        $view,
        $create,
        $edit,
    ]);
   //-----------------------------------Set-role-super-admin--------------------------------------
   
   $role2=Role::create(['guard_name' => 'admin','name'=>'Sadmin']);
   $role2->givePermissionTo([
        $view,
        $create,
        $edit,
        $delete
    ]);
    
    $sadmin =Admin::create([
        'username'=>'Sadmin02',
        'password'=> bcrypt('password'),
        'name'=>'superA',
        'role_id'=>'2'
    ]);  
    
    $sadmin->assignRole($role2);
    $sadmin->givePermissionTo([
        $view,
        $create,
        $edit,
        $delete
    ]);
}
}
