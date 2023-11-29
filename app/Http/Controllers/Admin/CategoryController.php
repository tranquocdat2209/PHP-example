<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;

class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index(Request $request)
    {
        $category = Category::query();
        if (!empty($request->get('keyword'))) {
            $category = $category->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $category = $category->paginate(5);
        return view('admin.categoris.list-category', [
            'title' => 'List Category',
            'items' => $category
        ]);
    }

    public function create()
    {
        return view('admin.categoris.new-category');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->show_home = $request->show_home;
            $category->save();

            // Lưu image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
                File::copy($sPath, $dPath);


                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($sPath)->resize(368, 248)->save($dPath);

                $category->image = $newImageName;
                $category->save();


            }
            $request->session()->flash("success", "Successfully created category");
            return response()->json([
                'status' => true,
                'message' => "Successfully created category"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($categoriId)
    {
        $item = $this->categoryModel->find($categoriId);

        if (empty($item)) {
            return redirect()->route('categoris.list');
        }
        return view('admin.categoris.edit', [
            'item' => $item,
        ]);
    }

    public function update($categoriId, Request $request)
    {
        $category = $this->categoryModel->find($categoriId);
        if (empty($category)) {
            $request->session()->flash("error", "Record not found");
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->passes()) {

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->show_home = $request->show_home;
            $category->save();

            $oldImage = $category->image;

            // Lưu image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id . '-' . time() . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
                File::copy($sPath, $dPath);


                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($sPath)->resize(368, 248)->save($dPath);

                $category->image = $newImageName;
                $category->save();

                File::delete(public_path() . '/uploads/category/thumb/' . $oldImage);
                File::delete(public_path() . 'uploads/category/' . $oldImage);
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

    public function delete($id, Request $request)
    {
        Category::find($id)->delete();
        $request->session()->flash("success", "Successfully deleted category");
        return response()->json([
            'status' => true,
        ]);
    }
}
