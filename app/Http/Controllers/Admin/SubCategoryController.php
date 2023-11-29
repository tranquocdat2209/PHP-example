<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    protected $subCategoryModel;

    public function __construct()
    {
        $this->subCategoryModel = new SubCategory();
    }

    public function index(Request $request)
    {
        $subCategory = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        if (!empty($request->get('keyword'))) {
            $subCategory = $subCategory->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subCategory = $subCategory->paginate(5);

        return view('admin.sub-categoris.list-sub-category', [
            'title' => 'Sub Category',
            'subCategory' => $subCategory
        ]);
    }

    public function create()
    {
        $category = Category::query()->orderBy('name', 'ASC')->get();
        return view('admin.sub-categoris.new-sub-category', [
            'title' => 'Sub Category',
            'items' => $category
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->passes()) {
            $subCategory = new SubCategory();
//            $subCategory->fill($request->all());
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category_id;
            $subCategory->show_home = $request->show_home;
            $subCategory->save();

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

    public function edit($subCategoriId)
    {
        $item = SubCategory::find($subCategoriId);
        $listSub = Category::orderBy('name', 'ASC')->get();
        if (empty($item)) {
            return redirect()->route('sub-categoris.list');
        }
        return view('admin.sub-categoris.edit-sub-category', [
            'items' => $item,
            'listCategoris' => $listSub
        ]);
    }

    public function update($subCategoriId, Request $request)
    {
        $subCategory = SubCategory::find($subCategoriId);
        if (empty($subCategory)) {
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
            'category' => 'required',
        ]);

        if ($validator->passes()) {

            $subCategory->update($request->all());

            $request->session()->flash("success", "Successfully update sub category");
            return response()->json([
                'status' => true,
                'message' => "Successfully update  sub category"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        SubCategory::find($id)->delete();

        $request->session()->flash("success", "Successfully deleted sub category");
        return response()->json([
            'status' => true,
        ]);
    }
}
