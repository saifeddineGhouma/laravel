<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        \Gate::authorize('view','products');
        $products = Product::latest()->paginate();
        return ProductResource::collection($products);
    }
    public function show($id)
    {
        \Gate::authorize('view','products');
        $product = Product::find($id);
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        \Gate::authorize('edit','products');
     //   $file = $request->file('image');

        $name = Str::random(10);
       // $url = Storage::putFileAs('images',$file , $name.'.'.$file->extension());
       $product = Product::create(
           [
               'name'=>$request->name,
               'description'=>$request->description,
               'image'=>$request->image ,//env('APP_URL').'/'.$url,
               'price'=>$request->price
           ]
       );

       return response()->json([
           'data'=>new ProductResource($product)
       ]);
    }
    public function upload(Request $request)
    {
        \Gate::authorize('edit','products');
           $file = $request->file('picture');

           $name = Str::random(10);
          $url = Storage::putFileAs('images',$file , $name.'.'.$file->extension());
          return env('APP_URL').'/'.$url ;
    }
    public function update($id , Request $request )
    {
        \Gate::authorize('edit','products');
        $product = Product::find($id);
        $product->update($request->only('name','description','image','price'));
        return response()->json(['data' =>new ProductResource($product),'message'=>"success updated product","status_code"=>201]);
    }
    public function destroy($id)
    {
        \Gate::authorize('edit','products');
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message'=>"success delete user","status_code"=>201]);
    }
}
