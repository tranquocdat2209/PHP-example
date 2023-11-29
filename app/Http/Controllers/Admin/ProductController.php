<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = Product::latest('id')->with('productImage');
        if (!empty($request->get('keyword'))) {
            $product = $product->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $product = $product->paginate(5);

        return view('admin.products.list', [
            'products' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $colors = Color::query()->get();
        $size = Size::query()->get();
        $categories = Category::query()->orderBy('name', 'ASC')->get();
        return view('admin.products.add', [
            'categories' => $categories,
            'colors' => $colors,
            'size' => $size
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'qty' => 'required',
            'track_qty' => 'required|in:Yes,No',
            'category_id' => 'required|numeric',
            'is_feature' => 'required|in:Yes,No'
        ];
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $product = new Product();
            $product->fill($request->all());
            $product->save();

            //Save image

            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_image_id) {
                    $tempImage = TempImage::find($temp_image_id);
                    $extArray = explode('.', $tempImage->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                    $productImage->image = $imageName;
                    $productImage->save();

                    //Large image
                    $sourcePath = public_path() . '/temp/' . $tempImage->name;
                    $destPath = public_path() . '/uploads/products/large/' . $imageName;
                    $img = Image::make($sourcePath);
                    $img->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destPath);
                    //Small image
                    $destPath = public_path() . '/uploads/products/small/' . $imageName;
                    $img->fit(270, 334)->save($destPath);
                }
            }

            if (!empty($request->color)) {
                foreach ($request->color as $key => $color) {
                    $product->ProductColor()->create([
                        'product_id' => $product->id,
                        'color_id' => $color,
                    ]);
                }
            }

            if (!empty($request->size)) {
                foreach ($request->size as $key => $size) {
                    $product->ProductSize()->create([
                        'product_id' => $product->id,
                        'size_id' => $size,
                    ]);
                }
            }

            $request->session()->flash("success", "Successfully update category");
            return response()->json([
                'status' => true,
                'message' => "Successfully update category"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $category = Category::query()->get();
        $productImage = ProductImage::where('product_id', $product->id)->get();
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        if (empty($product)) {
            return redirect()->route('product.list');
        }
        return view('admin.products.edit', [
            'products' => $product,
            'categories' => $category,
            'subCategories' => $subCategories,
            'productImage' => $productImage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id . ',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id',
            'qty' => 'required',
            'track_qty' => 'required|in:Yes,No',
            'category_id' => 'required|numeric',
            'is_feature' => 'required|in:Yes,No'
        ];
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $product->update($request->all());

            $request->session()->flash("success", "Successfully update category");
            return response()->json([
                'status' => true,
                'message' => "Successfully update category"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        Product::find($id)->delete();
        $request->session()->flash("success", "Successfully deleted category");
        return response()->json([
            'status' => true,
        ]);
    }
}
