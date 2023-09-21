@php
use App\Models\StageTrack;
@endphp

@extends('backend')

@section('page_level_css_plugins')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<link href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('page_level_css_files')
    <style>
    .clickable-row {
        cursor: pointer;
    }
    </style>
@endsection

@section('content')

<div class="container-fluid">
<div class="row">
    <div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ $commons['content_title'] }}</h1>

            <div class="card-tools">
                Note:: [ You have to scroll Left => Right to see the full content ]
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
           <!-- filter -->
            <div class="form-group">
                <label for="taskFilter">Filter by Status</label>
                <select class="form-control" id="taskFilter">
                    <option value="">Filter data</option>
                    <option value="0">Not started</option>
                    <option value="3">Approved</option>
                    <option value="2">On-progress</option>
                    <option value="4">Rejected</option>
                </select>
            </div>


        <table class="table table-bordered table-responsive">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th class="clickable-task">Task</th>
                      <th class="clickable-sbu">SBU</th>
                      <th class="clickable-status">Task Status</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $row)
                    <tr class="clickable-row" data-href="{{ route('stage.show', $row->task_id) }}" data-task-id="{{ $row->task_id }}" data-user-role="{{ auth()->user()->role->slug }}" data-task-status="{{ $row->getTaskStatus() }}">
                      <td>{{ $loop->iteration }}.</td>
                      <td class="clickable-task">{{ $row->task_title }}</td>
                      <td class="clickable-sbu">{{ $row->sbu->name }}</td>
                     
                      <td class="clickable-status">
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
                      
                    </tr>
                 
                  </tbody>

                @endforeach
              </table>

              <div class="card-footer clearfix">
                {{ $tasks->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
        <!-- /.card-body -->     
    </div>
  </div>
</div>
</div>


   <!-- /.modal Section here -->

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
                        <option value="3">Completed</option>
                        <option value="4">Rejected</option>
                    </select>
                <span id="taskStatusError" class="text-danger"></span> <!-- Error message for Task status -->
                </div>
               

                    <!-- Container for dynamic content -->

                    <div id="dynamicContent"></div>

                <div class="row">
                        <div class="col-md-7">
                        <label for="office">Attachment Title</label>
                            <select class="form-control" id="attachTitle">
                                <option value="">Select Attachment Title</option>
                                <option value="1">Chalan Paper</option>
                                <option value="2">Noc</option>
                                <option value="3">Recipent copy</option>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="fileUpload">Attachment(if any)</label>
                                <input type="file" class="form-control-file" id="fileUpload">
                            </div>
                        </div>                                           
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
      <!-- /. End of modal -->

@endsection

<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page_level_js_plugins')
<script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('Custom/js/custom.js') }}"></script>


@endsection
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page_level_js_scripts')


<!-- Row click functionality -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("click", function(event) {
        const clickedElement = event.target;
        const clickableRow = clickedElement.closest(".clickable-row");

        if (clickableRow) {
            const userRoleSlug = clickableRow.getAttribute("data-user-role");

            if (clickedElement.classList.contains("clickable-task") ||
                clickedElement.classList.contains("clickable-sbu")) {
                const url = clickableRow.getAttribute("data-href");
                if (url) {
                    window.location.href = url;
                }
            } else if (clickedElement.classList.contains("badge")) {
                const taskID = clickableRow.getAttribute("data-task-id");

                if (userRoleSlug !== 'system_admin') {
                    openModalWithTaskID(taskID); // Pass the task ID to the function
                }
            }
        }
    });

    function openModalWithTaskID(taskID) {
        // Open the modal and populate fields based on taskID
        const modal = document.getElementById("modal-lg");
        const taskTitleField = modal.querySelector("#taskTitle");
        const taskIDField = modal.querySelector("#taskID");
        const taskSBUField = modal.querySelector("#taskSBU");

        // Use an AJAX request to get the task data based on the taskID
        $.ajax({
            url: "getTaskData/" + taskID,
            method: "GET",
            success: function(response) {
                taskTitleField.value = response.task_title; // Populate the task title field
                taskIDField.value = response.task_id; // Populate the task ID field
                
                // Populate SBU name
                if (response.sbu) {
                    taskSBUField.value = response.sbu.name;
                } else {
                    taskSBUField.value = '';
                }

                // Format dates
                function formatDate(date) {
                    var year = date.getFullYear();
                    var month = String(date.getMonth() + 1).padStart(2, '0');
                    var day = String(date.getDate()).padStart(2, '0');
                    return year + '-' + month + '-' + day;
                }

                var startDate = new Date(response.start_date);
                var endDate = new Date(response.end_date);

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

                // ... Populate other fields as needed based on the response

                // Open the modal
                $(modal).modal("show");
            },
            error: function(error) {
                console.log("Error fetching task data:", error);
            }
        });
    }

    
// Get the task filter element
const taskFilter = document.getElementById("taskFilter");

// Add a change event listener to the task filter
taskFilter.addEventListener("change", function() {
    // Get the selected value from the task filter
    let selectedValue = parseInt(taskFilter.value);

    // Handle the case where the selected value is not a number (NaN)
    if (isNaN(selectedValue)) {
        selectedValue = 0; // Set to "All"
    }

    // Get all rows with the class "clickable-row"
    const rows = document.querySelectorAll(".clickable-row");

    // Show/hide rows based on the selected filter
    rows.forEach(function(row) {
    const taskStatus = parseInt(row.getAttribute("data-task-status"));

    if (selectedValue === 0) {
        // Show only "Not started" tasks when "Not started" is selected
        if (taskStatus === 0) {
            row.style.display = ""; // Show
        } else {
            row.style.display = "none"; // Hide
        }
    } else if (taskStatus === selectedValue) {
        // Show tasks matching the selected status
        row.style.display = ""; // Show
    } else {
        row.style.display = "none"; // Hide
    }
});


});





});
</script>


@endsection



