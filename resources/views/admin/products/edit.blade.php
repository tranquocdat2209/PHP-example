@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper" style="min-height: 817px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="products.html" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form method="put" action="" id="productFormUpdate" name="productForm" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" class="form-control"
                                                       placeholder="Title" id="title" value="{{ $products->title }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control"
                                                       placeholder="Slug" readonly value="{{ $products->slug }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10"
                                                          class="summernote" placeholder="Description"
                                                          style="display: none;"
                                                          value="">{{ $products->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Media</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="product-gallery">
                                @if($productImage->isNotEmpty())
                                    @foreach($productImage as $image)
                                        <div class="col-md-3" id="image-row-{{ $image->id }}">
                                            <div class="card">
                                                <input type="hidden" value="{{ $image->id }}"
                                                       name="image_array[]">
                                                <img src="{{ asset('uploads/products/small/' . $image->image) }}"
                                                     class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <a href="javascription:void(0)"
                                                       onclick="deleteImage({{ $image->id }})"
                                                       class="btn btn-primary">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control"
                                                       placeholder="Price" value="{{ $products->price }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price"
                                                       class="form-control" placeholder="Compare Price"
                                                       value="{{ $products->compare_price }}">
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into
                                                    Compare
                                                    at price. Enter a lower value into Price.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku" class="form-control"
                                                       placeholder="sku" value="{{ $products->sku }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode">Barcode</label>
                                                <input type="text" name="barcode" id="barcode" class="form-control"
                                                       placeholder="Barcode" value="{{ $products->barcode }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="hidden" name="track_qty" value="No">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty"
                                                           name="track_qty"
                                                           value="Yes" {{ $products->track_qty == 'Yes' ? 'checked' : '' }}>
                                                    <label for="track_qty" class="custom-control-label">Track
                                                        Quantity</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="qty">Qty</label>
                                                <input type="number" min="0" name="qty" id="qty" class="form-control"
                                                       placeholder="Qty" value="{{ $products->qty }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $products->status == 1 ? 'selected' : '' }} value="1">Active
                                            </option>
                                            <option {{ $products->status == 0 ? 'selected' : '' }} value="0">Block
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="">Select a category</option>
                                            @if($categories->isNotEmpty())
                                                @foreach($categories as $category )
                                                    <option
                                                        {{ $category->id == $products->category_id ? 'selected' : ''  }}
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="error"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Sub category</label>
                                        <select name="sub_category_id" id="sub_category" class="form-control">
                                            <option value="">Select a category</option>
                                            @if($subCategories->isNotEmpty())
                                                @foreach($subCategories as $category )
                                                    <option
                                                        {{ $products->sub_category_id == $category->id ? 'selected' : '' }}
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{--                            <div class="card mb-3">--}}
                            {{--                                <div class="card-body">--}}
                            {{--                                    <h2 class="h4 mb-3">Product brand</h2>--}}
                            {{--                                    <div class="mb-3">--}}
                            {{--                                        <select name="status" id="status" class="form-control">--}}
                            {{--                                            <option value="">Apple</option>--}}
                            {{--                                            <option value="">Vivo</option>--}}
                            {{--                                            <option value="">HP</option>--}}
                            {{--                                            <option value="">Samsung</option>--}}
                            {{--                                            <option value="">DELL</option>--}}
                            {{--                                        </select>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Featured product</h2>
                                    <div class="mb-3">
                                        <select name="is_feature" id="is_feature" class="form-control">
                                            <option {{ $products->is_feature == 'No' ? 'selected' : '' }} value="No">
                                                No
                                            </option>
                                            <option {{ $products->is_feature == 'Yes' ? 'selected' : '' }} value="Yes">
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $('#productFormUpdate').submit(function (event) {
            event.preventDefault();
            var $element = $(this).serializeArray()
            $.ajax({
                type: "PUT",
                url: "{{ route('product.update',$products->id) }} ",
                data: $element,
                dataType: "json",
                success: function (res) {
                    if (res["status"] === true) {
                        window.location.href = ("{{ route('product.list') }}");
                    } else {
                        var error = res["errors"]
                        $(".error").removeClass("invalid-feedback").html("");
                        $("input[type=text], input[type=checkbox], input[type=number], select").removeClass("is-invalid");
                        $.each(error, function (key, item) {
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass("invalid-feedback").html(item);
                        })
                    }
                }
            })
        });
        $('#category').change(function () {
            var $category_id = $(this).val()
            $.ajax({
                type: "get",
                url: "{{ route('product.subcategories')}}",
                data: {category_id: $category_id},
                dataType: "json",
                success: function (res) {
                    $("#sub_category").find("option").not(":first").remove()
                    $.each(res["subCategories"], function (key, item) {
                        $("#sub_category").append(`<option value="${item.id}">${item.name}</option>`)
                    })
                }
            })
        });
        $("#title").change(function () {
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
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: "{{ route('product-images.update') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {'product_id': '{{ $products->id }}'},
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, response) {
                var html = `<div class="col-md-3" id="image-row-${response.image_id}">
                    <div class="card" >
                        <input type="hidden" value="${response.image_id}" name="image_array[]">
                        <img src="${response.imagePath}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="javascription:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-primary">Remove</a>
                        </div>
                    </div>
                    </div>`
                $("#product-gallery").append(html);
            },
            complete: function (file) {
                this.removeFile(file);
            }
        });

        function deleteImage($id) {
            $('#image-row-'+ $id).remove();
            if (confirm('Are you sure you want to delete')) {
                $.ajax({
                    url: '{{ route("product-images.destroy") }}',
                    type: 'delete',
                    data: {id: $id},
                    success: function (res) {
                        console.log(res)
                    }
                })
            }
        }
    </script>
@endsection
