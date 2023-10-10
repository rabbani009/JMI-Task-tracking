@php
use App\Models\StageTrack;
@endphp

@extends('backend')

@section('page_level_css_plugins')
<!-- Include  CSS plugins here -->
@endsection

@section('page_level_css_files')
<!-- Include  CSS files here -->
@endsection

@section('content')
<section class="content">
<div class="card">
<div class="row">
    <div class="col-md-12">
        
            <div class="card-body">
                <div class="card bg-gray-light">
                    <div class="card-header">
                        <h3 class="card-title text-primary"><i class="fas fa-filter"></i> Filter Desire Data</h3>
                        <div class="card-tools">
                            <button type="button" title="collapse" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" title="remove" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filter_task">Task Wise</label>
                                    <select class="form-control select-select2" id="filter_task">
                                        <option value=''>--Select--</option>
                                        @foreach($tasks as $taskId => $taskTitle)
                                            <option value='{{ $taskTitle }}'>{{ $taskTitle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filter_sbu">SBU Wise</label>
                                    <select class="form-control select-select2" id="filter_sbu" style="width: 100%;">
                                        <option value="">-- Select --</option>
                                        @foreach($sbus as $sbuId => $sbuName)
                                            <option value="{{ $sbuId }}">{{$sbuName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                          

                        <div class="row">
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filter_status">Status Wise</label>
                                    <select class="form-control select-select2" id="filter_status" style="width: 100%;">
                                        <option value="">-- Select --</option>
                                        <option value="Approved">Approved</option>
                                        <option value="On-progress">On-progress</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filter_person">Person wise</label>
                                    <select class="form-control select-select2" id="filter_person" style="width: 100%;">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filter_product_type">Product Types</label>
                                    <select class="form-control select-select2" id="filter_product_type" style="width: 100%;">
                                        <option value="">-- Select --</option>
                                        <option value="Finished Product">Finished Product</option>
                                        <option value="Manufacturing">Manufacturing Product</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 btn-group">
                            <!-- <button onclick="searchTasks()" class="btn btn-primary"> <i class="fas fa-search"></i> Search</button> -->

                            <div class="ml-2 nav-item dropdown">
                                <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-download mr-1"></i> Download <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" tabindex="-1" href="javascript:;" data-scope="pdf" id="pdfButton">
                                        <i class="fa fa-file-pdf mr-2"></i> PDF
                                    </a>
                                    <a class="dropdown-item" tabindex="-1" href="javascript:;" data-scope="xls">
                                        <i class="fa fa-file-excel mr-2"></i> Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive-md table-responsive-lg table-responsive-md table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Title</th>
                            <th>SBU</th>
                            <th>User</th>
                            <th>Belongs office</th>
                            <th>Task Status</th>
                            <th>Product Type</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    @foreach ($taskall as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->task_title }}</td>
                                <td>{{ $row->sbu->name }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>
                                @foreach(json_decode($row->a_office) as $step)
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
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $taskall->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
                        
    </div>
</div>
</div>
</section>
@endsection

@section('page_level_js_plugins')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection

@section('page_level_js_scripts')

<script>

document.getElementById('filter_task').addEventListener('change', () => {
let selectedTask = document.getElementById('filter_task').value;
$.ajax({
    type: 'get',
    url: 'filter-task-wise-data',
    data: {
        taskTitle: selectedTask // Use 'taskTitle' here
    },
    success: function(res) {
        console.log(res);
        $('#tableBody').html(res);
    },
    error: function(error) {
        console.log(error);
    }
});
});

document.getElementById('filter_sbu').addEventListener('change', function() {
    let selectedSbu = this.value;
    $.ajax({
        type: 'get',
        url: 'filter-sbu-wise-data',
        data: {
            sbu: selectedSbu
        },
        success: function(res) {
            // console.log(res);
            $('#tableBody').html(res);
        },
        error: function(error) {
            console.log(error);
        }
    });
});

document.getElementById('filter_person').addEventListener('change', function() {
    let selectedPerson = this.value;
    $.ajax({
        type: 'get',
        url: 'filter-person-wise-data',
        data: {
            person: selectedPerson
        },
        success: function(res) {
            // console.log(res);
            $('#tableBody').html(res);
        },
        error: function(error) {
            console.log(error);
        }
    });
});

document.getElementById('filter_product_type').addEventListener('change', function() {
    let selectedProduct = this.value;
    $.ajax({
        type: 'get',
        url: 'filter-product-wise-data',
        data: {
            product: selectedProduct
        },
        success: function(res) {
            // console.log(res);
            $('#tableBody').html(res);
        },
        error: function(error) {
            console.log(error);
        }
    });
});




///PDF script



document.getElementById('pdfButton').addEventListener('click', function() {
    // Redirect to the PDF generation route
    window.location.href = '{{ route("generate-pdf") }}';
});


</script>



@endsection
