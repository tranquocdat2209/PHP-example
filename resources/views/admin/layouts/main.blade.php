<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.head')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
@include('admin.layouts.header')
<!-- /.navbar -->
    <!-- Main Sidebar Container -->
@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->
    @include('admin.layouts.footer')
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('admin/js/demo.js') }}"></script>
<script src="{{ asset('admin/js/app.js') }}"></script>


<script type="text/javascript">
    $('.summernote').summernote({
        height: '115px !important',
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('customJs')
</body>
</html>
