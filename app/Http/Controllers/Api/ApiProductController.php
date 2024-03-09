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
        return $this->apiPaginateResponse(Product::with('supplier'), ProductResource::class);
        // $products = Product::paginate(5);
        // return $products->withQueryString()->links();
        // return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) {
        //
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
