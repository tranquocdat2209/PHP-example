<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id . '-' . $productImage->id . '-' . time() . '.' . $ext;
        $productImage->image = $imageName;
        $productImage->save();

        //Large image
        $destPath = public_path() . '/uploads/products/large/' . $imageName;
        $img = Image::make($sourcePath);
        $img->resize(270, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destPath);
        //Small image
        $destPath = public_path() . '/uploads/products/small/' . $imageName;
        $img->fit(270, 334)->save($destPath);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'imagePath' => asset('/uploads/products/small/' . $productImage->image),
            'message' => "Successfully update image"
        ]);
    }

    public function destroy(Request $request){
        $productImage = ProductImage::find($request->id);
        if(empty($productImage)){
            return response()->json([
            'status' => false,
            'message' => "Error not found"
        ]);
        }
//        Delete iamge from folder
        File::delete(public_path('/uploads/products/small/' . $productImage->image));
        File::delete(public_path('/uploads/products/large/' . $productImage->image));

        $productImage->delete();
         return response()->json([
            'status' => true,
            'message' => "Successfully delete image"
        ]);
    }
}
