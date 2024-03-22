<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\Services\HandlesImages;
use Illuminate\Http\UploadedFile;

class ProductService {
    use HandlesImages;

    protected $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
        $this->storage = app('filesystem')->disk();
    }

    public function createProduct(array $data, ?UploadedFile $image): Product {
        $data['image_path'] = $this->handleImageUpload($image, 'images/products');

        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, array $data, ?UploadedFile $image): Product {
        if ($image) {
            $this->handleImageDeletion($product->image_path);
            $data['image_path'] = $this->handleImageUpload($image, 'images/products');
        }

        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product): void {
        $this->handleImageDeletion($product->image_path);

        if ($product->hasConstraints()) {
            $this->productRepository->softDelete($product);
        } else {
            $this->productRepository->forceDelete($product);
        }
    }
}
