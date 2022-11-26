<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required'
        ]);

        if (!$request->has('product_image')) {
            $product = Product::create([
                'title' => $request -> input('title'),
                'description' => $request -> input('description'),
                'product_image' => '',
                'price' => $request -> input('price'),
            ]);
            // return response()->json(['message' => 'Missing file'], 422);
        }else{
            // $file = $request->file('product_image');
            // $name = Str::random(10);
            //$url = Storage::putFileAs('product_image', $file, $name . '.' . $file->extension());
            $image_path = $request -> file('product_image') -> store('product_image', 'public');
            $product = Product::create([
                'title' => $request -> input('title'),
                'description' => $request -> input('description'),
                'product_image' => $image_path,
                'price' => $request -> input('price'),
            ]);
        }
        

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

    /**
     * search the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Product::where('title', 'like', '%' .$title. '%')->get();
    }
}
