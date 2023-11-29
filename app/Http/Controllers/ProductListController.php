<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index(Request $request, $categorySlug = null)
    {
        $categories = Category::query()->get();
        $title = "";
        $products = Product::query()->where('status', 1);
        $colors = Color::query()->get();

        // filter category
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $title = $category->name;
            $products = $products->where('category_id', $category->id);
        }

        //filter color

        if (!empty($request->input('color'))) {
            $color = $request->input('color');
            $productColor = ProductColor::query()->where('color_id', $color)->get();
            $arr = [];
            foreach ($productColor as $key => $product) {
                array_push($arr, $product->product_id);
            }
            $products = $products->whereIn('id', $arr);
        }
        //filter price

        if($request->get('price_min') != '' && $request->get('price_max') != ''){
            if($request->get('price_max' == 1000)){
                 $products = $products->whereBetween('price',[intval($request->get('price_min')),100000]);
            }else{
                 $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
            }
        }

        //sort
        if($request->get('sort')){
            if($request->get('sort') == 'new-product'){
                $products = $products->orderBy('id','DESC');
            }else if($request->get('sort') == 'price-high-to-low'){
                $products = $products->orderBy('price','DESC');
            }else if($request->get('sort') == 'price-low-to-high'){
                $products = $products->orderBy('price','ASC');
            }else if($request->get('sort') == 'name-a-z'){
                $products = $products->orderBy('title','ASC');
            }else{
                $products = $products->orderBy('title','DESC');
            }
        }else{
            $products = $products->orderBy('id','DESC');
        }
        $products = $products
            ->with('productImage')
            ->paginate(4);

        return view('frontend.product-list', [
            'title' => $title,
            'products' => $products,
            'categories' => $categories,
            'colors' => $colors,
            'priceMin' => intval($request->get('price_min')),
            'priceMax' => (intval($request->get('price_max')) === 0 ? 1000 : intval($request->get('price_max'))),
            'sort' => $request->get('sort'),
        ]);
    }
}
