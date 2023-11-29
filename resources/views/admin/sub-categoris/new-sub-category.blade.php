@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper" style="min-height: 817px;">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Sub Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('sub-categoris.list') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form action="" method="post" id="subCategoryForm" name="categoryForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Category</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="0">Select a category</option>
                                            @foreach($items as $item )
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                               placeholder="Slug" readonly>
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Show Home</label>
                                        <select name="show_home" id="show_home" class="form-control">
                                            <option value="Yes">Show</option>
                                            <option value="No">Hide</option>
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
        $('#subCategoryForm').submit(function (event) {
            event.preventDefault();
            var $element = $(this)
            $.ajax({
                type: "POST",
                url: "{{ route('sub-categoris.store')}}",
                data: $element.serializeArray(),
                dataType: "json",
                success: function (res) {
                    if (res["status"] == true) {
                        window.location.href = ("{{ route('sub-categoris.list') }}");
                        // $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        // $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        // $("#category").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        var errors = res['errors'];
                        var error = res["errors"]
                        $(".error").removeClass("invalid-feedback").html("");
                        $("input[type=text], select").removeClass("is-invalid");
                        $.each(error, function (key, item) {
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass("invalid-feedback").html(item);
                        })
                    }
                }
            })
        })
        $("#name").change(function () {
            var $element = $(this)
            $.ajax({
                type: "get",
                url: "{{ route('getSlug')}}",
                data: {title: $element.val()},
                dataType: "json",
                success: function (res) {
                    if (res["status"] == true) {
                        $("#slug").val(res["slug"])
                    }
                }
            })
        })

    </script>
@endsection
