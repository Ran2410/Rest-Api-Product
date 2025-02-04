<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Fascades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            "status" => 200,
            'data' => $products
        ], 200); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'status' => 201,
            'data' => $product
        ], 201);

    } catch (ValidationException) {
        return response()->json([
            'success' => false,
            'status' => 400,
            'message' => 'Bad Request',
        ], 400);
    }
}


/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id) 
{ 
    $product = Product::find($id); 
    
    if (!$product) { 
        return response()->json(
            ['success' => false, 
            'status' => 404, 
            'message' => 'Product not found'
        ], 404); 
    } 
    try {
        $request->validate([ 
            'name' => 'sometimes|required|string|max:255', 
            'price' => 'sometimes|required|numeric', 
            'stock' => 'sometimes|required|integer' 
        ]); 
        
        $product->update($request->all()); 
        
        return response()->json([ 
            
            'success' => true, 
            'status' => 200,
            'data' => $product 
        ]); 
        
    } catch (ValidationException) {
        return response()->json([
            'success' => false,
            'status' => 400,
            'message' => 'Bad Request',
        ], 400);
    }
} 

/**
 * Display the specified resource.
 */
public function show(string $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(
            ['success' => false, 
            "status" => 404,
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        "status" => 200,
        'data' => $product
    ]);
}

    public function destroy(string $id)
    {
        $product = Product::find($id);


        if (!$product) {
            return response()->json(['success' => false, "status" => 404, 'message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['success' => true, 'status' => 204, 'message' => 'Product deleted 
       successfully' ], 204);
    }
}