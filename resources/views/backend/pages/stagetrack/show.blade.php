@extends('backend')

@section('page_level_css_plugins')

@endsection

@section('page_level_css_files')
    
@endsection

@section('content')
   
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
        <div class="card">
          

        <div class="card-body">
            <table class="table table-responsive-md table-responsive-lg table-responsive-md text-center">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Stage Status
                      </th>
                      <th style="width: 15%">
                          Start Date
                      </th>
                      <th style="width: 15%">
                          End Date
                      </th>
                      <th>
                          Attachments
                      </th>
                      <th style="width: 8%" class="text-center">
                          Task Status
                      </th>
                      <th style="width: 20%">
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
                              Created : {{ $data->created_at }}
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
                      <td class="project-actions text-right">
                          
                          <a class="btn btn-info btn-sm" href="#">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
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
