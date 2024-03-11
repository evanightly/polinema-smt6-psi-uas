<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends ApiController {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return $this->apiPaginateResponse(Product::with(['supplier', 'transactions'])->latest(), ProductResource::class);
        // $products = Product::paginate(5);
        // return $products->withQueryString()->links();
        // return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) {

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $request->merge(['image_path' => $imagePath]);
        }

        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) {
        return new ProductResource($product->load(['supplier', 'transactions']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) {
        // check the image first, if it exists, delete it from storage, then store it again
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('local')->delete('public/' . $product->image_path);
            }
            $imagePath = $request->file('image')->store('images/products', 'public');
            $request->merge(['image_path' => $imagePath]);
        }
        $product->update($request->all());
        return new ProductResource($product->load(['supplier', 'transactions']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        if (!$product->canBeDeleted()) {
            return response()->json(['message' => 'Product cannot be deleted because it has transactions.'], 400);
        }
        if ($product->image_path) {
            Storage::disk('local')->delete('public/' . $product->image_path);
        }
        Product::destroy($product->id);
        return response()->noContent();
    }
}
