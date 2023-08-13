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
    @include('backend.pages.task._table')
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
