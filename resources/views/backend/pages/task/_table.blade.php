@php
use App\Models\StageTrack;
@endphp

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
                        <th>Task Id</th>
                        <th>SBU</th>
                        <th>Assigned user</th>
                        <th>Start Date</th>
                        <th>Expected DueDate</th>        
                        <th>No.of Stage</th>     
                        <th>Task Status</th>
                        <th>product Types</th>
                        <th>product class</th>
                        <th>Target office</th>


                        <th class="custom_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tasks as $row)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $row->task_title}}</td>
                        <td>{{ $row->task_id}}</td>
                        <td>{{ $row->sbu->name}}</td>
                        <td>{{ $row->user->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($row->start_date)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->end_date)->format('Y-m-d') }}</td>
                        <td>
                        @foreach(json_decode($row->task_approved_steps) as $step)
                            {{ $step }},
                        @endforeach
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
                            <a href="#" type="button" class="btn btn-flat btn-outline-info btn-sm notify-btn" data-toggle="modal" data-target="#modal-lg" data-task-id="{{ $row->task_id }}" title="Notify">
                                <i class="fa fa-plus-square"></i>
                            </a>
                                                        
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

   <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Task Track</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <span id="successMessage" class="text-success" style ="text-align:center"></span> <!-- Error message for Stage status -->
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="taskID">Task Title</label>
                            <input type="text"  class="form-control" id="taskTitle" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="taskID">Task ID</label>
                            <input type="text"  class="form-control" id="taskID" readonly>
                        </div>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                            <label for="taskSBU">SBU</label>
                            <input type="text"  class="form-control" id="taskSBU" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stageStatus">Notify stage Status</label>
                    <select class="form-control" id="stageStatus">

                        <option value="">Select stage status</option>
                     
                    </select>
                <span id="stageStatusError" class="text-danger"></span> <!-- Error message for Stage status -->
                </div>

                <div class="form-group">
                    <label for="office">Notify Task status</label>
                    <select class="form-control" id="taskStatus">
                        <option value="">Select Task status</option>
                        <option value="1">Started</option>
                        <option value="2">Working</option>
                        <option value="3">Completed</option>
                        <option value="4">Rejected</option>
                    </select>
                <span id="taskStatusError" class="text-danger"></span> <!-- Error message for Task status -->
                </div>
               

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                                <label for="">Date of Approval *</label>
                                <div class="input-group date" id="start_date" data-target-input="nearest">
                                    <input value="{{ old('start_date') }}" type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date" autocomplete="off" placeholder="YYYY-MM-DD">
                                    <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @if($errors->has('start_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('end_date')) has-error @endif">
                                <label for="">Expected date of Approval *</label>
                                <div class="input-group date" id="end_date" data-target-input="nearest">
                                    <input type="text" name="end_date" value="{{ old('end_date') }}" class="form-control datetimepicker-input" data-target="#end_date" autocomplete="off" placeholder="YYYY-MM-DD">
                                    <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @if($errors->has('end_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div>
                        </div>
                </div>


                <div class="form-group">
                    <label for="fileUpload">Attachment(if any)</label>
                    <input type="file" class="form-control-file" id="fileUpload">
                </div>
                <!-- Add other task fields as needed -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="saveChangesBtn">New Productivity</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $(document).ready(function() {
        $(".notify-btn").on("click", function() {
            var taskId = $(this).data("task-id");

            $.ajax({
                url: "getTaskData/" + taskId,
                method: "GET",
                success: function(response) {
                    // Update the modal fields with the retrieved data
                    $("#taskTitle").val(response.task_title);
                    $("#taskID").val(response.task_id);
                      // Check if SBU data exists in the response
                        if (response.sbu) {
                            $("#taskSBU").val(response.sbu.name); // Populate the SBU name
                        } else {
                            $("#taskSBU").val(''); // Clear the SBU name field if no SBU data found
                        }

                    // Convert the start_date and end_date strings to Date objects
                    var startDate = new Date(response.start_date);
                    var endDate = new Date(response.end_date);

                    // Format the dates as "YYYY-MM-DD"
                    var formattedStartDate = formatDate(startDate);
                    var formattedEndDate = formatDate(endDate);

                    $("#startDate").val(formattedStartDate);
                    $("#endDate").val(formattedEndDate);
    
                    // Parse the JSON string for task_approved_steps
                var approvedSteps = JSON.parse(response.task_approved_steps);

                // Add the approvedSteps as options to the taskStatus dropdown

                var taskStatusDropdown = $("#stageStatus");
                taskStatusDropdown.empty(); // Clear existing options
                approvedSteps.forEach(function(step) {
                taskStatusDropdown.append('<option value="' + step + '">' + step + '</option>');
                });

                    // Show the modal
                    $("#modal-lg").modal("show");
                },
                error: function(error) {
                    console.log("Error fetching task data:", error);
                }
                
            });
                function formatDate(date) {
                    var year = date.getFullYear();
                    var month = String(date.getMonth() + 1).padStart(2, '0');
                    var day = String(date.getDate()).padStart(2, '0');
                    return year + '-' + month + '-' + day;
                }
        });

            // Handling stage_track form submission
            $("#saveChangesBtn").on("click", function() {

                var $button = $(this); // Store a reference to the button
                console.log("Button clicked");
                
                // Disable the button to prevent multiple clicks
                $button.prop("disabled", true);

            var formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('task_id', $("#taskID").val());
            formData.append('task_status', $("#taskStatus").val());
             formData.append('stage_status', $("#stageStatus").val());
            formData.append('start_date', $("#start_date input").val());
            formData.append('end_date', $("#end_date input").val());

               // Append multiple attachments (if any)
                var attachmentFiles = $("#fileUpload")[0].files;
                for (var i = 0; i < attachmentFiles.length; i++) {
                    formData.append('attachments[]', attachmentFiles[i]); // Use 'attachments[]' key here
                }

            // AJAX post request to save the data
            $.ajax({
                url: "saveTaskTrackData",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle the success response here, e.g., show a success message
                    console.log("Data saved successfully:", response);
                       // Clear error messages
                    $("#taskStatusError").text("");
                    $("#stageStatusError").text("");

                    // Display a success message at the top of the modal
                     $("#successMessage").text("Data saved successfully").removeClass("d-none");
                },
                error: function(error) {
                    console.log("Error saving task track data:", error);

                        // Handle the error response here
                        if (error.responseJSON && error.responseJSON.message) {
                            // Display error messages below the input fields
                            if (error.responseJSON.message.includes("same data already exists")) {
                                $("#taskStatusError").text("A record with the same data already exists.");
                            } else if (error.responseJSON.message.includes("already exists with a different task_status")) {
                                $("#stageStatusError").text("You have already give the entry");
                            }
                        }
                },
                complete: function() {
                     // Re-enable the button after the AJAX request is complete
                    console.log("Request complete");
                    $button.prop("disabled", false);
                }
            });
        });
    
    });
</script>








