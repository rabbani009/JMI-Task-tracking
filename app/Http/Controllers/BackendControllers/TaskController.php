<?php

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Models\Sbu;
use App\Models\User;
use App\Models\Task;
use App\Models\StageTrack;
use Illuminate\Support\Facades\Gate;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commons['page_title'] = 'Task';
        $commons['content_title'] = 'List of All Task';
        $commons['main_menu'] = 'main_task';
        $commons['current_menu'] = 'task_all';


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
            ->with(['sbu', 'user', 'createdBy', 'updatedBy', 'stageTracks'])         
            ->paginate(3);

            

        }else{

            $tasks = Task::where('status', 1)
            ->where('user_id', auth()->user()->id)
            ->with(['sbu', 'user', 'createdBy', 'updatedBy', 'stageTracks'])  
            ->paginate(3);
    
            // dd($tasks);

        }
      

        return view('backend.pages.task.index',
            compact(
                'commons',
                'tasks'

            )
        );
          


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commons['page_title'] = 'Task';
        $commons['content_title'] = 'Add new Task';
        $commons['main_menu'] = 'main_task';
        $commons['current_menu'] = 'task_create';

        $sbus = Sbu::where('status', 1)
        //  ->where('id', auth()->user()->belongs_to)
         ->pluck('name', 'id'); 

         $users = User::where('status',1)
         ->where('user_type','user')
         ->pluck('name','id');



        return view('backend.pages.task.create',
            compact(
                'commons',
                'sbus',
                'users'
                
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        // dd($request);
        

            // Validation passed, proceed to store the task
            $validatedData = $request->validated();

            // Convert the array to a JSON-encoded string
            $taskApprovedSteps = json_encode($validatedData['task_approved_steps']);
            $a_office = json_encode($validatedData['a_office']);


            // Generate the unique task_id
            $taskId = $this->generateUniqueId();

            // Create and store the task in the database
            $task = new Task();
            $task->task_id = $taskId;
            $task->sbu_id = $validatedData['sbu_id'];
            $task->task_title = $validatedData['task_title'];
            $task->user_id = $validatedData['user_id'];
            $task->task_approved_steps = $taskApprovedSteps;
            $task->start_date = $validatedData['start_date'];
            $task->end_date = $validatedData['end_date'];
            $task->p_type = $validatedData['p_type'];
            $task->p_class = $validatedData['p_class'];
            $task->a_office = $a_office;
            // Save the task to the database
            $task->save();

            if ($task->wasRecentlyCreated){
                return redirect()
                    ->back()
                    ->with('success', 'Task created successfully!');
            }
    
            return redirect()
                ->back()
                ->with('failed', 'Task is not create!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
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
    public function update(Request $request, $id)
    {
        //
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

  //Generate Unique Task ID

    private function generateUniqueId()
    {
        return str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    // Mark as finished Task

     public function complete(Task $task)
        {
            
            // Toggle the task status between 0 (ongoing) and 3 (finished)
            $newStatus = $task->task_status === 0 ? 3 : 0;
            $task->update(['task_status' => $newStatus]);
        
            // Return the updated task status in the response
            return back()->with('success', 'Task status updated.');
        }
    
    
    
    
    
    



    
    
    




}
