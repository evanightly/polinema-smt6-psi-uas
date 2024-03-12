<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class ApiProductController extends ApiController {

    private $productService;
    private $productRepository;

    public function __construct(ProductService $productService, ProductRepository $productRepository) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function index() {
        $options = request()->query('options', []);
        $searchFields = ['name'];
        $relations = ['supplier'];
        $products = $this->productRepository->get($options, $searchFields, $relations);
        return $this->apiPaginateResponse($products, ProductResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) {
        $product = $this->productService->createProduct($request->validated(), $request->file('image'));
        return new ProductResource($product);
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
        $product = $this->productService->updateProduct($product, $request->validated(), $request->file('image'));
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        $this->productService->deleteProduct($product);
        return response()->noContent();
    }
}
