@if ( Session::has('error') )
    <div class="alert alert-danger" role="alert" id="alert-danger">
        {{ Session::get('error') }}
    </div>
    <script type="text/javascript">
        setTimeout(() => {
            document.getElementById("alert-danger").remove();
        }, 5000)
    </script>
@endif
@if ( Session::has('success') )
    <div class="alert alert-success" role="alert" id="alert-success">
        {{ Session::get('success') }}
    </div>
    <script type="text/javascript">
        setTimeout(() => {
            document.getElementById("alert-success").remove();
        }, 5000)
    </script>
@endif
