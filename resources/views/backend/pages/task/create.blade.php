@extends('backend')

@section('page_level_css_plugins')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<link href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page_level_css_files')

@endsection

@section('content')
<section class="content">
    @if($errors->any())
        <div class="card pl-3 bg-danger">
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ $commons['content_title'] }}</h1>

            <div class="card-tools">
                Note:: * marked fields are required
            </div>
        </div>
        <form action="{{ route('task.store') }}" method="post" data-bitwarden-watching="1" enctype="multipart/form-data" accept-charset="UTF-8">
            @csrf
            <div class="card-body">
                <!-- Prerequisites section -->
                <div class="container-fluid card ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group  @if ($errors->has('council')) has-error @endif">
                                <label class="control-label">Select SBU *</label>
                                
                                {{ Form::select('sbu_id', $sbus, old('sbu_id')?old('sbu_id'):null, ['id="council", class="form-control select2"']) }}

                                @if($errors->has('sbu_id'))
                                    <span class="error invalid-feedback"> {{ $errors->first('sbu_id') }} </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group  @if ($errors->has('user')) has-error @endif">
                                <label class="control-label">Assigned People *</label>
                                
                                {{ Form::select('user_id', $users, old('user_id')?old('user_id'):null, ['id="council", class="form-control select2"']) }}

                                @if($errors->has('user_id'))
                                    <span class="error invalid-feedback"> {{ $errors->first('user_id') }} </span>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- Time and location section -->
                <div class="container-fluid card ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('activity_title')) has-error @endif">
                                <label for="">Task Title *</label>
                                <input type="text" name="task_title" class="form-control @if($errors->has('task_title')) is-invalid @endif" value="{{ old('task_title') }}" placeholder="Enter Task or Product Name">
                                @if($errors->has('task_title'))
                                    <span class="error invalid-feedback">{{ $errors->first('task_title') }}</span>
                                @else
                                    <span class="help-block"> This field is required. </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Task Approved Steps</label>
                            <div class="select2-purple">
                                <select name= task_approved_steps[] class="select2" multiple="multiple" data-placeholder="Select Steps sequently" data-dropdown-css-class="select2-purple" style="width: 100%;">

                                    <option value="Receving PMD from source">Receving PMD from source</option>
                                     <option value="Submitting Product Application">Submitting Product Application</option>
                                    <option value="Recipent approval">Recipent approval</option>
                                    <option value="Registration(Brand approval)">Registration(Brand approval)</option>
                                    <option value="Registration(Package approval)">Registration(Package approval)</option>
                                    <option value="Price approval">Price approval</option>
                                    <option value="Marketing Authorization">Marketing Authorization</option>
                                    <option value="Inspection">Inspection</option>

                                    <option value="Meeting Date">Meeting Date</option>

                                    <option value="recipe approved">recipe approved</option>

                                    <option value="brand name approved">brand name approved</option>

                                    <option value="packaging approved">packaging approved</option>

                                    <option value="registration process completed">registration process completed</option>
                               </select>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                                <label for="">Start date *</label>
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
                                <label for="">Expected End date *</label>
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
                    
                </div>

                <!-- Fund -->
                <div class="container-fluid card ">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group  @if ($errors->has('p_type')) has-error @endif">
                            <label class="control-label">Select Type *</label>
                            <select name="p_type" class="form-control">
                                <option>Select Type</option>	
                                <option value="Finished product">Finished Product</option>
                                <option value="Manufacturing">Manufacturing</option>	
                                <option value="Others">Others</option>			
                                
                            </select>
                            @if($errors->has('p_type'))
                                <span class="error invalid-feedback"> {{ $errors->first('p_type') }} </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group  @if ($errors->has('p_class')) has-error @endif">
                            <label class="control-label">Select Class *</label>
                            <select name="p_class" class="form-control">
                                <option>Select Class</option>	
                                <option value="A">A</option>
                                <option value="B">B</option>	
                                <option value="C">C</option>
                                <option value="D">D</option>				                               
                            </select>
                            @if($errors->has('p_class'))
                                <span class="error invalid-feedback"> {{ $errors->first('p_class') }} </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                      
                        <div class="form-group">
                            <label>Select Offices</label>
                            <div class="select2-purple">
                                <select name= a_office[] class="select2" multiple="multiple" data-placeholder="Select offices" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                    <option value="DGDA">DGDA</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            
        </form>
    </div>

</section>

@endsection


<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page_level_js_plugins')
<script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endsection
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page_level_js_scripts')
<script>
    /// Event loading...
    document.addEventListener('DOMContentLoaded', function() {
        $('.select2').select2()
        $('#council').select2({passive: true});
        $("#area_of_expertise").select2({
            tags: true,
            tokenSeparators: [','],
            passive: true // Mark the event listener for this element as passive
        });

        $(function () {
            $('#start_date').datetimepicker({
                default: true,
                format: 'L',
                locale: 'BST',
                format: 'YYYY-MM-DD'
            });
            $('#end_date').datetimepicker({
                default: true,
                format: 'L',
                locale: 'BST',
                format: 'YYYY-MM-DD',
                placeholder: 'Select End Date'
            });
        });
    }, {passive: true}); // Mark the document event listener as passive
</script>
@endsection
