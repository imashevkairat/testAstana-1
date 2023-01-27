<?php

namespace App\Http\Controllers;

use App\Models\Applications;
use App\Models\Vacancies;
use App\Models\UserChats;
use Illuminate\Http\Request;


class ApplicationsController extends Controller
{


    public function index(){

        if (auth()->user()->role == 0) {
          $query_string = 'auth_id';
        }else{
          $query_string = 'user_id';
        }
        $applications = Applications::on()->where($query_string,auth()->user()->getAuthIdentifier())->get();

        return view('applications',[
            'applications'=>$applications
        ]);
    }


    public function showUserChat(Request$request){
         $applications = Applications::on()->find($request['vacan_id']);
         $history_chat = UserChats::on()->where('application_id',$applications['id'])->get();

        return response(['applications'=>$applications,'history_chat'=>$history_chat]);
    }


    public function sendUserChat(Request$request){

        $saveChat = new UserChats();
        $saveChat['auth_id'] = auth()->user()->id;
        $saveChat['application_id'] = $request['application_id'];
        $saveChat['text'] = $request['input_chat'];
        $saveChat->save();

        $allChatUser = UserChats::on()->where('application_id',$request['application_id'])->get();


        return response(['applications'=>false,'history_chat'=>$allChatUser]);
    }


    public function applicationRole(Request$request){
         $application_role =  Applications::on()->find($request['application_id']);
         $application_role['type'] = $request['application_role'];
         $application_role->save();

         return response(['applications'=>$application_role]);
    }
}
