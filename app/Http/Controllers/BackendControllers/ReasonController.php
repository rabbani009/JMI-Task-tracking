<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class ReasonController extends Controller
{
    
    public function update(Request $request, $task_id)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,task_id',
            'reason' => 'required|string',
        ]);
    
        // Find the task by its ID
       $task = Task::where('task_id', $task_id)->first();

        // Update or create the reason
        $task->update([
            'remarks' => $request->input('reason'),
        ]);
    
        return redirect()->back()->with('success', 'Reason updated successfully.');
    }
    


}
