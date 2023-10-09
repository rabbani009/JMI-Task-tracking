<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\StageTrack;


use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function getTaskData($taskId)
    {
        $task = Task::with('sbu')->where('task_id', $taskId)->first();

        $sbuName = $task->sbu ? $task->sbu->name : null;

        if ($task) {
            return response()->json($task);
        }

        return response()->json(['error' => 'Task not found'], 404);
    }

//stage_track store

public function saveTaskTrackData(Request $request)
{
            // Validate the form data (including file attachments) as needed
            $request->validate([
                'task_id' => 'required',
                'task_status' => 'required',
                'stage_status' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'attachments.*' => 'nullable|file|max:2048', // Adjust max file size as needed
            ]);

            // Retrieve the authenticated user's ID
            $userId = Auth::id();


                // Define the stage_status and task_status values
            $stageStatus = $request->input('stage_status');
            $taskStatus = $request->input('task_status');
            $attachmentTitle = $request->input('attachment_title');
            $reasonDescription = $request->input('reason_description');

                // Check if a record with the same stage_status, task_status, and user_id combination already exists
            $existingRecord = StageTrack::where('task_id', $request->input('task_id'))
            ->where('stage_status', $stageStatus)
            ->where('task_status', $taskStatus)
            ->where('user_id', $userId)
            ->first();

            if ($existingRecord) {
            return response()->json(['message' => "A record with the same data already exists"], 422);
            }

            // Check if a record with the same stage_status and user_id combination already exists with a different task_status
            $existingRecordWithDifferentTaskStatus = StageTrack::where('task_id', $request->input('task_id'))
            ->where('stage_status', $stageStatus)
            ->where('user_id', $userId)
            ->where('task_status', '<>', $taskStatus)
            ->first();

            if ($existingRecordWithDifferentTaskStatus) {
            return response()->json(['message' => "A record with the stage_status '$stageStatus' already exists with a different task_status"], 422);
            }


            // Save the task track data to the database
            $stageTrack = new StageTrack();
            $stageTrack->task_id = $request->input('task_id');
            $stageTrack->task_status = $request->input('task_status');
            $stageTrack->stage_status = $request->input('stage_status');
            $stageTrack->start_date = $request->input('start_date');
            $stageTrack->end_date = $request->input('end_date');
            $stageTrack->user_id = $userId; // Assign the user ID
            $stageTrack->attachment_title = $attachmentTitle;
            $stageTrack->reason_description = $reasonDescription;

            // Save file attachments to the server and store their paths in the database
            if ($request->hasFile('attachments')) {
                $attachmentPaths = [];
                foreach ($request->file('attachments') as $attachment) {
                    $path = $attachment->store('attachments'); // Store in the public/attachments folder
                    $attachmentPaths[] = $path;
                }
                $stageTrack->attachments = json_encode($attachmentPaths);
            }


            // Save the model to the database
            $stageTrack->save();

            // Return a response indicating success or any other necessary information
            // return response()->json(['message' => 'Task track data saved successfully']);

            return redirect()->back()->with('success', 'Task track data updated successfully.');
        }

    
        


}
