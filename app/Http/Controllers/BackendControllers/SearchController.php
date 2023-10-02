<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Sbu;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{


    public function search(Request $request)
    {
        $filtered_task = Task::where('status', 1)
            ->where('task_title', $request->taskTitle)
            ->paginate(24);
    
        if ($filtered_task->isEmpty()) {
            // No data found, return an empty array
            $filtered_task = [];
        }
    
        $view = view('backend.pages.report.filtered_table', compact('filtered_task'))
            ->render();
    
        return $view;
    }
    
    public function searchsbu(Request $request)
    {
        $filtered_task = Task::where('status', 1)
            ->where('sbu_id', $request->sbu)
            ->paginate(24);
    
        if ($filtered_task->isEmpty()) {
            // No data found, return an empty array
            $filtered_task = [];
        }
    
        $view = view('backend.pages.report.filtered_table', compact('filtered_task'))
            ->render();
    
        return $view;
    }

    public function searchperson(Request $request)
    {
        $filtered_task = Task::where('status', 1)
            ->where('user_id', $request->person)
            ->paginate(24);
    
        if ($filtered_task->isEmpty()) {
            // No data found, return an empty array
            $filtered_task = [];
        }
    
        $view = view('backend.pages.report.filtered_table', compact('filtered_task'))
            ->render();
    
        return $view;
    }

    public function searchproduct(Request $request)
    {
        $filtered_task = Task::where('status', 1)
            ->where('p_type', $request->product)
            ->paginate(24);
    
        if ($filtered_task->isEmpty()) {
            // No data found, return an empty array
            $filtered_task = [];
        }
    
        $view = view('backend.pages.report.filtered_table', compact('filtered_task'))
            ->render();
    
        return $view;
    }
    
    
    

}