<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json(Product::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|255',
            'description'=>'required',
            'price'=>'required|numeric',
        ]);

        $product = Product::create($validatedData);

        return response()->json($product,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if($product){
            return response()->json($product,200);
        } else {
            return response()->json(['message','Product not found'],404);  
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
      ]);

      //check if the product was found
      if($product){
        $product->update($validatedData);

      // Return the updated product as a JSON response with a 200 HTTP status code

        return response()->json($product,200);
      } 
      // Return a 404 Not Found HTTP status code if the product was not found
      return response()->json(['message' => 'Product not found'], 404);
  

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product){
            $product->delete();

            return response()->json(null,204);
        }else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);
        }
        
    }
}
