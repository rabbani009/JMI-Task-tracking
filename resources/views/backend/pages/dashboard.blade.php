@php
use App\Models\StageTrack;
@endphp

@extends('backend')

@section('page_level_css_plugins')

@endsection

@section('page_level_css_files')

@endsection

@section('content')

      <div class="row">
        <div class="col-md-8">
       
             
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered table-responsive">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Task</th>
                      <th>SBU</th>
                      <th>Progress</th>
                      <th>Task Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $row)
                    <tr>
                      <td>{{ $loop->iteration }}.</td>
                      <td>{{ $row->task_title}}</td>
                      <td>{{ $row->sbu->name}}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
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

                    </tr>
                 
                  </tbody>

                @endforeach
                </table>
              </div>
              <!-- /.card-body -->
            
        </div>
    </div>
          
         
  
@endsection

<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page_level_js_plugins')

{{-- <script src="{{ asset('AdminLTE-3.2.0/plugins/chart.js/Chart.min.js') }}"></script> --}}

@endsection
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page_level_js_scripts')
<script>
 
</script>

@endsection
