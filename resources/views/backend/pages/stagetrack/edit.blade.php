@extends('backend')

@section('page_level_css_plugins')

@endsection

@section('page_level_css_files')
    
@endsection

@section('content')
   
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif

<div class="col-md-6">
    <div class="card">
        
    <div class="col-md-6 offset-md-6 text-right">
        <button type="button" class="btn btn-primary" onclick="window.history.back();"><i class="fas fa-caret-left"></i><i class="fas fa-caret-left"></i>  Previous</button>
    </div>


        <div class="card-body">

            <form action="{{ route('stage.update', $stageTracks->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Display errors here if needed -->

                <!-- Add form fields for editing stage_track step data -->
                <div class="form-group">
                    <label for="stage_status">Stage Status:</label>
                    <input type="text" name="stage_status" class="form-control" value="{{ $stageTracks->stage_status }}" readonly>
                </div>

                <div class="form-group">
                    <label for="task_status">Task Status:</label>
                    <select name="task_status" class="form-control">
                        <!-- <option value="1" {{ $stageTracks->task_status == 1 ? 'selected' : '' }}>Started</option> -->
                        <option value="">Select</option>
                        <option value="3" {{ $stageTracks->task_status == 3 ? 'selected' : '' }}>Completed</option>
                        <option value="4" {{ $stageTracks->task_status == 4 ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date">Date:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $stageTracks->start_date }}">
                </div>

                
                <div class="form-group">
                    <label for="message">Reason(if you select rejected):</label>
                    <textarea id="message" name="reason_description" class="form-control" rows="4" placeholder="Enter your reason here...">{{ $stageTracks->reason_description }}</textarea>
                </div>


                <div class="form-group">
                    <label for="attachTitle">Attachment Title:</label>
                     <select class="form-control" id="attachTitle" name="attachTitle">

                     <option value="">Select Attachment Title</option>
                    <option value="Chalan Paper" {{ $stageTracks->attachment_title == 'Chalan Paper' ? 'selected' : '' }}>Chalan Paper</option>
                    <option value="Noc" {{ $stageTracks->attachment_title == 'Noc' ? 'selected' : '' }}>Noc</option>
                    <option value="Recipent copy" {{ $stageTracks->attachment_title == 'Recipent copy' ? 'selected' : '' }}>Recipient copy</option>

                     </select>
                </div>

                <div class="form-group">
                    <label for="fileUpload">Attachment (if any):</label>
                    @if (!empty($stageTracks->attachments))
                        <div>
                            <a href="{{ asset($stageTracks->attachments[0]) }}" target="_blank">
                                <i class="fas fa-paperclip"></i>Attachment available
                            </a>
                        </div>
                    @else
                        <p>No attachment available.</p>
                    @endif
                    <input type="file" class="form-control-file" id="fileUpload" name="fileUpload">
                </div>

                <!-- Add more form fields as needed -->

                <div class="col-md-6 offset-md-6 text-right">
                    <button type="submit" class="btn btn-primary">Update Progress</button>
                </div>
                
            </form>
        </div>
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
