@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper" style="min-height: 817px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Size</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('size.list') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                @include('admin.message')
                <form action="" method="post" id="sizeForm" name="sizeForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="exampleColorInput" class="form-label">Size</label>
                                        <input type="text" class="form-control form-control-color"
                                               title="Choose your color" name="size">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('customJs')
    <script>
        $('#sizeForm').submit(function (event) {
            event.preventDefault();
            var $element = $(this).serializeArray()
            $.ajax({
                type: "POST",
                url: "{{ route('size.store')}}",
                data: $element,
                dataType: "json",
                success: function (res) {
                    if (res["status"] === true) {
                        window.location.href = ("{{ route('size.list') }}");
                    } else {
                        var error = res["errors"]
                        $(".error").removeClass("invalid-feedback").html("");
                        $("input[type=text]").removeClass("is-invalid");
                        $.each(error, function (key, item) {
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass("invalid-feedback").html(item);
                        })
                    }
                }
            })
        });

    </script>
@endsection
