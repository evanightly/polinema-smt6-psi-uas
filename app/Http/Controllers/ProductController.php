<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return inertia('Products/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return inertia('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) {
        //
    }

    /**
     * Show the restock info for the specified resource.
     */
    public function showRestockInfo() {
        return inertia('Products/RestockInfo', ['appUrl' => env('APP_URL')]);;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {
        return inertia('Products/Edit', ['product' => $product->load(['supplier', 'transactions'])]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        //
    }
}
