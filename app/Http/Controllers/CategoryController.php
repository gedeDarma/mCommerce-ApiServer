<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function __construct()
    {
    //   $this->middleware('auth:api')->except(['index', 'show']);
        //$this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        
        //Get all products
        $categories = Category::all();
 
        // Return a collection of $products with pagination
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'remark' => $request->remark
        ]);
    
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        //
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->only(['name', 'remark']));
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    { 
        if($category->delete()) {
            return new CategoryResource($category);
        } 

        // $product->delete();
        // return response()->json(null, 204);
    }
}
