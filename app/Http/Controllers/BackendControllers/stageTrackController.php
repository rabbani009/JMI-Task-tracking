<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StageTrack;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;


class stageTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($task_id)
    {
        $commons['page_title'] = ' Task Progress';
        $commons['content_title'] = ' Task Progress';
        $commons['main_menu'] = 'activity';
        $commons['current_menu'] = 'activity_details';

        $taskData = StageTrack::where('task_id', $task_id)
            ->orderBy('created_at', 'Asc')
            ->get();

        // dd($taskData);

        $task = Task::where('task_id', $task_id)->first();

        return view('backend.pages.stagetrack.show',
            compact(
                'commons',
                'taskData',
                'task'

            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commons['page_title'] = 'Edit Progress';
        $commons['content_title'] = 'Edit Task Progress';
        $commons['main_menu'] = 'edit progress';
        $commons['current_menu'] = 'edit progress';


        $stageTracks = StageTrack::findorfail($id);
        
        return view('backend.pages.stagetrack.edit',compact('stageTracks','commons'));
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
            // Validate the form data
            $request->validate([
                'task_status' => 'required|in:3,4',
                'start_date' => 'required|date',
                'fileUpload.*' => 'nullable|mimes:jpeg,jpg,png,gif,pdf,docx', // Note the '.*' to validate each uploaded file
            ]);

            // Find the existing stage track record
            $stageTrack = StageTrack::find($id);

            if (!$stageTrack) {
                return redirect()->back()->with('error', 'Stage track not found');
            }

            // Update the stage track data
            $stageTrack->task_status = $request->input('task_status');
            $stageTrack->start_date = $request->input('start_date');
            $stageTrack->attachment_title = $request->input('attachTitle');

             // Handle file upload if a new file is provided
            if ($request->hasFile('fileUpload')) {
                // Delete the old attachment if it exists
                if (!empty($stageTrack->attachments)) {
                    Storage::delete(json_decode($stageTrack->attachments)[0]);
                }

                $path = $request->file('fileUpload')->store('attachments');
                $stageTrack->attachments = json_encode([$path]);
            }

            $stageTrack->save();

            return redirect()->back()->with('success', 'Progress updated successfully');


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
