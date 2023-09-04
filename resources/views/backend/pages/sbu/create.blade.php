@extends('backend')

@section('page_level_css_plugins')

@endsection

@section('page_level_css_files')

@endsection

@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">{{ $commons['content_title'] }}</h1>

                <div class="card-tools">
                    Note::
                </div>
            </div>
            <form action="{{ route('sbu.store') }}" method="post" data-bitwarden-watching="1" enctype="multipart/form-data" accept-charset="UTF-8">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name or Title</label>
                        <input type="text" name="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{!! old('name') !!}" placeholder="Enter SBU Name">
                        @if($errors->has('name'))
                            <span class="error invalid-feedback">{!! $errors->first('name') !!}</span>
                        @else
                            <span class="help-block"> This field is required. </span>
                        @endif
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

@endsection
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page_level_js_scripts')
    <script>


    </script>
@endsection
