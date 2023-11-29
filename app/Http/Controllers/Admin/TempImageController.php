<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Image;

//use Image;

class TempImageController extends Controller
{
    public function create(Request $request)
    {
        $image = $request->image;
        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '.' . $ext;
            // add image db
            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path() . '/temp', $newName);


            $sourcePath = public_path() . '/temp/' . $newName;
            $destPath = public_path() . '/temp/thumb/' . $newName;

            $img = Image::make($sourcePath)->resize(300,300)->save($destPath);

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'imagePath' => asset('/temp/thumb/' . $newName),
                'message' => 'Image saved successfully',
            ]);
        }
    }
}
