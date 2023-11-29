<?php

use App\Models\Category;

function getMenu()
{
    return Category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->where('status', 1)
        ->limit(8)
        ->get();
}

function getCategoryHome()
{
    return Category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->where('status', 1)
        ->where('show_home', 'Yes')
        ->limit(3)
        ->get();
}

function getProductByCategory()
{
    return Category::query()
        ->where('show_home', 'Yes')
        ->with('product')
        ->limit(8)
        ->get();
}

//function getUrlCategory(Request $request)
//{
//    $prductUri = substr($request->getRequestUri(), 1);
//
//    return Category::where('slug', $prductUri)
//        ->with('product')
//        ->get();
//}
