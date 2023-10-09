@php
use App\Models\StageTrack;
@endphp

<style>
    .step-list {
        display: none; /* Initially hide the step list */
    }

    .step-toggle {
        cursor: pointer;
        color: blue; /* Customize the style as needed */
    }

    /* Style for the expanded step list */
    .step-list.show {
        display: block;
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 5px;
        background-color: #f5f5f5;
    }

    /* Style for individual steps */
    .step {
        margin-bottom: 5px;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .table thead th {
        background-color: #E4F1FF; 
        color: #333; 
    }
</style>



<section class="content">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ $commons['content_title'] }}</h1>

            <div class="card-tools">
                Note:: [ You have to scroll Left => Right to see the full content ]
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body p-0">
            <table class="table table-responsive text-center table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Task Title</th>
                        <th>SBU</th>
                        <th>Assigned user</th>
                        <th>Task opening Date</th>
                        <th>Expected Closing Date</th>        
                        <th>No.of Stage</th>     
                        <th>Task Status</th>
                        <th>product Types</th>
                        <th>product class</th>
                        <th>Target office</th>
                        <th>Remarks</th>


                        <th class="custom_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tasks as $row)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $row->task_title}}</td>
                        <td>{{ $row->sbu->name}}</td>
                        <td>{{ $row->user->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($row->start_date)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->end_date)->format('Y-m-d') }}</td>
                        <td>
                            <span class="step-toggle">Show Steps</span>
                            <div class="step-list">
                                @foreach(json_decode($row->task_approved_steps) as $step)
                                    <div class="step">
                                        {{ $step }}
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        <td>
                            @php
                                $taskApprovedSteps = json_decode($row->task_approved_steps, true);

                                $approvedStages = StageTrack::where('task_id', $row->task_id)
                                    ->whereIn('stage_status', $taskApprovedSteps)
                                    ->where('task_status', 3)
                                    ->get();
                                    
                                
                                    foreach ($approvedStages as $stage) {
                                        
                                        }

                                $allStagesApproved = $approvedStages->count() === count($taskApprovedSteps);
                                $anyStages = $row->stageTracks->isNotEmpty();
                            @endphp

                            @if ($allStagesApproved)
                                <span class="badge badge-pill badge-success">Approved</span>
                            @elseif ($anyStages)
                                <span class="badge badge-pill badge-info">On-Progress</span>
                            @else
                                <span class="badge badge-pill badge-warning">Not Started</span>
                            @endif
                      </td>

                        <td>{{ $row->p_type }}</td>                      
                        <td>{{ $row->p_class }}</td>
                        <td>
                        @foreach(json_decode($row->a_office) as $step)
                            {{ $step }},
                        @endforeach
                        </td>

                        <td>
                            @php
                                    $expectedClosingDate = \Carbon\Carbon::parse($row->end_date);
                                    $currentDate = \Carbon\Carbon::now();

                                    if ($currentDate->gt($expectedClosingDate)) {
                                        // The current date is greater than the expected closing date, so it's finished.
                                        echo "Time finished";
                                    } else {
                                        // Calculate the days remaining, considering years, months, and days.
                                        $diff = $expectedClosingDate->diff($currentDate);
                                        $daysRemaining = $diff->format('%m months, %d days');
                                        echo $daysRemaining . " left";
                                    }
                                @endphp
                        </td>

                        <td class="custom_actions">
                            <div class="btn-group">
                                <a href="{{ route('stage.show', $row->task_id) }}" class="btn btn-flat btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                    <i class="far fa-eye"></i>
                                </a>
                                    
                            @if(auth()->user()->role->slug != 'sbu_admin')      
                                <a href="" class="btn btn-flat btn-outline-info btn-sm" data-toggle="tooltip" title="Edit">
                                   <i class="far fa-edit"></i>
                                </a>
                            @endif

                            @if(auth()->user()->role->slug == 'sbu_admin') 

                            <a href="#" type="button" class="btn btn-flat btn-outline-info btn-sm notify-btn open-reason-modal"
                            data-toggle="modal"
                            data-target="#reasonModal"
                            data-task-id="{{ $row->task_id }}"
                            data-remarks="{{ $row->remarks }}"
                            title="Notify">
                            <i class="fa fa-plus-square"></i> Reason
                            </a>



                            @endif
                                                        
                           @if(auth()->user()->role->slug != 'sbu_admin') 
                                <form method="post" class="list_delete_form" action="" accept-charset="UTF-8" >
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-flat btn-outline-danger btn-sm" data-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>

                                        </button>
                                </form>
                            @endif
        
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{ $tasks->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>


   <!-- /.modal -->

   <!-- Modal for Add/Update Reason -->
   <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel">Add/Update Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reasonForm"  method="POST">
                    @csrf
                    <!-- Include a hidden input field for task_id -->
                    <input type="hidden" name="task_id" value="{{ $row->task_id }}">
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4">{{ $row->remarks ?? '' }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="reasonForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
  </div>




</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function() {
        $(".step-toggle").click(function() {
            // Toggle the visibility of the step list
            $(this).siblings(".step-list").toggle();
        });
    });
</script>


<script>
// Make an AJAX POST request when the form is submitted


$(document).ready(function() {
    // Add a click event listener to the modal trigger buttons
    $('.open-reason-modal').on('click', function() {
        // Get the task_id and remarks from data attributes
        const task_id = $(this).data('task-id');
        const remarks = $(this).data('remarks');
        
        // Update the form action URL with the correct task_id
        const url = "{{ route('updateReason', ['task_id' => '__task_id__']) }}";
        const updatedUrl = url.replace('__task_id__', task_id);
        $('#reasonForm').attr('action', updatedUrl);

        // Set the task_id and remarks in the form input fields
        $('#reasonForm input[name="task_id"]').val(task_id);
        $('#reason').val(remarks);
    });
});


  
</script>






