<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $size = Size::query();
        if (!empty($request->get('keyword'))) {
            $size = $size->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $size = $size->paginate(5);
        return view('admin.attributes.size.list', [
            'size' => $size,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.size.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->passes()) {
            $size = new Size();
            $size::query()->create($request->all());


            $request->session()->flash("success", "Successfully create size");
            return response()->json([
                'status' => true,
                'message' => "Successfully create size"
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
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::query()->find($id);
        return view('admin.attributes.size.edit', [
            'size' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->passes()) {
            $size = Size::query()->find($id);
            $size->update($request->all());

            $request->session()->flash("success", "Successfully update size");
            return response()->json([
                'status' => true,
                'message' => "Successfully update size"
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
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        Size::find($id)->delete();
        $request->session()->flash("success", "Successfully deleted category");
        return response()->json([
            'status' => true,
        ]);
    }
}
