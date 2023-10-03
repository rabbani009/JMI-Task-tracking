@extends('backend')

@section('page_level_css_plugins')

@endsection

@section('page_level_css_files')
<style>
  .justify-text {
     
      white-space: pre-wrap;
  }
  .justify-text::after {
      content: '';
      display: inline-block;
      width: 100%;
      height: 0;
      visibility: hidden;
  }
</style>
  
@endsection

@section('content')
   
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
        <div class="card">

      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-6">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">Total Task Approval Steps</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              @foreach(json_decode($task->task_approved_steps) as $step)
              <div>
                <i class="fas fa-arrow-right bg-blue"></i>
                <div class="timeline-item">
                 
                  <h3 class="timeline-header">{{$step}}</h3>
                </div>
              </div>
              @endforeach
              <!-- END timeline item -->

             
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
          <div class="timeline">
                <div class="time-label">
                        <span class="bg-red">Task Details</span>
                </div>
         </div>
          <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                
                <h3 class="profile-username text-center">{{$task->task_title}}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>SBU : </b> <a class="float-right">{{ $task->sbu->name}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Task Opening Date : </b> <a class="float-right">{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Expected Closing Date : </b> <a class="float-right">{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</a>
                  </li>
                 
                  <li class="list-group-item">
                      <b>Target Office :</b>
                      @php
                          $a_office = json_decode($task->a_office);
                          $combinedOffice = implode(', ', $a_office);
                      @endphp
                      <a class="float-right">{{ $combinedOffice }}</a>
                  </li>

                </ul>

              </div>
              <!-- /.card-body -->
            </div>


          </div>
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->

        </div>
        <div class="card">
       

        <div class="card-body">
            <table class="table table-responsive-md table-responsive-lg table-responsive-md table-bordered text-center">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Stage
                      </th>
                      <th style="width: 15%">
                          Start/Approval/Reject Date
                      </th>
                      <th style="width: 15%">
                          Expected Approval Date
                      </th>
                      <th>
                          Attachments
                      </th>
                      <th>
                          Reason
                      </th>
                      <th style="width: 8%" class="text-center">
                           Stage Status
                      </th>
                      <th style="width: 20%">
                          Update Progress
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
              @foreach ($taskData as $data)
                  <tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a>
                          {{ $data->stage_status }}
                          </a>
                          <br/>
                          <small>
                              created_date : {{ $data->created_at->format('Y-m-d') }}<br />
                              Updated_date : <span class="badge badge-warning">{{ $data->updated_at->format('Y-m-d') }}</span>
                          </small>

                      </td>
                      <td>
                          {{ $data->start_date }}
                      </td>
                      <td>
                          {{ $data->end_date }}
                      </td>
                      <td class="project_progress">

                      
                        
                      @if (!empty($data->attachments))
                            <?php
                                $attachmentList = json_decode($data->attachments, true);
                                $filename = basename($attachmentList[0]);
                                $attachmentPath = 'attachments/' . $filename;
                            ?>
                            <a href="{{ asset($attachmentPath) }}" download="{{ $filename }}">
                                <i class="far fa-file"></i> Download Attachment
                            </a>
                        @else
                            &nbsp;
                        @endif

                     </td>

                      <td>
                          <div class="truncate-text">
                              @if (strlen($data->reason_description) > 0) <!-- Show the "View More" button if content is not empty -->
                                  <span class="truncated-text">{{ substr($data->reason_description, 0, 50) }}...</span>
                                  <button class="btn btn-link view-more-btn" data-toggle="collapse" data-target="#reason-{{ $data->id }}">View More</button>
                                  <div id="reason-{{ $data->id }}" class="collapse card">
                                      <div class="card-body justify-text">
                                          {{ $data->reason_description }}
                                      </div>
                                  </div>
                              @endif
                          </div>
                      </td>
                  
                      <td class="project-state">
                           @if($data->task_status == 1)
                                 <span class="badge badge-pill badge-info"> Started </span>
                            @elseif($data->task_status == 2)
                                 <span class="badge badge-pill badge-info"> Working </span>
                            @elseif($data->task_status == 3)
                                <span class="badge badge-pill badge-success"> Completed </span>
                            @elseif($data->task_status == 4)
                                <span class="badge badge-pill badge-danger"> Rejected </span>
                            @endif
                      </td>
                    @if(auth()->user()->role->slug != 'system_admin')  
                      <td class="project-actions text-center">
                          
                          <a class="btn btn-info btn-sm" href="{{ route('stage.edit', ['stage' => $data->id]) }}">
                              <i class="fas fa-pencil-alt">
                              </i>
                            
                          </a>
                          <!-- <a class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                             
                          </a> -->
                      </td>
                    @endif
                  </tr>

                @endforeach 
               
              </tbody>
          </table>

            </div>
        </div>

 

@endsection


<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page_level_js_plugins')

@endsection
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page_level_js_scripts')

@endsection
