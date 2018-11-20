<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Resources\ProductResource;
use JWTAuth;

class ProductController extends Controller
{
    // public function __construct()
    // {
    // //   $this->middleware('auth:api')->except(['index', 'show']);
    //     //$this->middleware('auth:api')->except(['index', 'show']);
    // }

    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        
        //Get all products
        $products = Product::all();
 
        // Return a collection of $products with pagination
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'category_id' => $request->category()->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'remark' => $request->remark
        ]);
    
        return new ProductResource($product);
    }

    public function show($id)
    {
         //Get all products
        $products = Product::where('id', $id)->get();
 
        // Return a collection of $products with pagination
        return ProductResource::collection($products);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->only(['category_id', 'name', 'description', 'price', 'stock', 'remark']));
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    { 
        if($product->delete()) {
            return new ProductResource($product);
        } 

        // $product->delete();
        // return response()->json(null, 204);
    }
}
