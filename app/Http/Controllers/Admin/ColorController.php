<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $color = Color::query();
        if (!empty($request->get('keyword'))) {
            $color = $color->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $color = $color->paginate(5);
        return view('admin.attributes.colors.list', [
            'colors' => $color,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.colors.add');
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
            $colors = new Color();
            $colors::query()->create($request->all());


            $request->session()->flash("success", "Successfully create colors");
            return response()->json([
                'status' => true,
                'message' => "Successfully create colors"
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
        $color = Color::query()->find($id);
        return view('admin.attributes.colors.edit', [
            'color' => $color
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
            $color = Color::query()->find($id);
            $color->update($request->all());

            $request->session()->flash("success", "Successfully update colors");
            return response()->json([
                'status' => true,
                'message' => "Successfully update colors"
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
        Color::find($id)->delete();
        $request->session()->flash("success", "Successfully deleted category");
        return response()->json([
            'status' => true,
        ]);
    }
}
