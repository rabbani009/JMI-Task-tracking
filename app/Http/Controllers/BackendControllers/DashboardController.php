<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use App\Models\Task;





class DashboardController extends Controller
{

    public function __construct(){

    }

    public function getDashboard(){
        $commons['page_title'] = 'Dashboard';
        $commons['content_title'] = 'Show dashboard';
        $commons['main_menu'] = 'dashboard';
        $commons['current_menu'] = 'dashboard';


      
        $users = auth()->user();
        // dd($users);
        if(!empty($users)){
            $user_type = $users->user_type;
            $user_name = $users->name;

        } else {
            $user_type = '';
            $user_name = '';
        }

        if($user_type=='system'){

            $tasks = Task::where('status', 1)
            ->orderBy('id', 'desc')
            ->with(['sbu','user','createdBy', 'updatedBy','stageTracks'])->paginate(7);
    
            // dd($tasks);

        }else{

            $tasks = Task::where('status', 1)
            ->where('user_id', auth()->user()->id)
            ->where('task_status', 0)
            ->orderBy('id', 'desc')
            ->with(['sbu','user','createdBy', 'updatedBy','stageTracks'])->paginate(7);
    
            // dd($tasks);

        }



        return view('backend.pages.dashboard',
            compact(
                'commons',
                'tasks'
               
            )
        );

    }

}
