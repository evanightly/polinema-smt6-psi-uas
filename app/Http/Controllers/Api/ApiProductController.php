<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;

class ApiProductController extends ApiController {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return $this->apiPaginateResponse(Product::with('supplier')->latest(), ProductResource::class);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        //
    }
}
