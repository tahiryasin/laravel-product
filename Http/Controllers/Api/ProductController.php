<?php

namespace Modules\Product\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Emails\ProductAdded;
use Modules\Product\Http\Requests\ProductStoreRequest;
use Modules\Product\Http\Requests\ProductUpdateRequest;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductLog;
use Modules\Product\Http\Middleware\CheckDefaultData;

class ProductController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->user = User::first();
    }

    public function index(Request $request)
    {
        $products = Product::with('creator','log')->when($request->input('name'), function($query, $name) {
            return $query->where('name', 'LIKE', "%$name%");
        })->when($request->input('user_id'), function($query, $userId) {
            return $query->where('created_by', $userId);
        })->get();

        return response()->json([
            'data' => $products
        ]);
    }


    public function store(ProductStoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->status = $request->input('status');
        $product->type = $request->input('type');
        $product->created_by = $this->user->id;
        $product->save();

        // send email notification to the user who added the product
        $user = User::find($product->created_by);
        \Mail::to($user->email)->send(new ProductAdded($product));

        return response()->json([
            'data' => $product
        ], 201);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());

        return response()->json([
            'data' => $product
        ]);
    }



    public function show($id)
    {
        $product = Product::with('creator','log')->find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['data'=>$product]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete(); // delete the product
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
