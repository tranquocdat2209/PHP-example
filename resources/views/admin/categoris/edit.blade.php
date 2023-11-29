@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper" style="min-height: 817px;">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('categoris.list') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form action="" method="post" id="categoryForm" name="categoryForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Name" value="{{ $item->name }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                               placeholder="Slug" readonly value="{{ $item->slug }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image">Image</label>
                                        <input type="hidden" name="image_id" id="image_id" value=""/>
                                        <div id="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.<br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="product-gallery">
                                        @if(!empty($item->image))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <img
                                                        src="{{ asset('uploads/category/thumb/' . $item->image) }}"
                                                        class="card-img-top" alt="...">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $item->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                            <option {{ $item->status == 0 ? 'selected' : '' }} value="0">Block</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Show Home</label>
                                        <select name="show_home" id="show_home" class="form-control">
                                            <option {{ $item->show_home == 'Yes' ? 'selected' : '' }} value="Yes">Show
                                            </option>
                                            <option {{ $item->show_home == 'No' ? 'selected' : '' }} value="No">Hide
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
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
        $('#categoryForm').submit(function (event) {
            event.preventDefault();
            var $element = $(this)
            $.ajax({
                type: "PUT",
                url: "{{ route('categoris.update', $item->id )}}",
                data: $element.serializeArray(),
                dataType: "json",
                success: function (res) {
                    if (res["status"] == true) {
                        window.location.href = ("{{ route('categoris.list') }}");
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        var errors = res['errors'];
                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                        if (errors['slug']) {
                            $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }
                }
            })
        })


        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, response) {
                $('#image_id').val(response.image_id)
            },
        });
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
