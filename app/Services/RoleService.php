<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Traits\HandlesImages;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;

class RoleService {
    use HandlesImages;

    protected $productRepository;

    public function __construct(RoleRepository $productRepository) {
        $this->productRepository = $productRepository;
        $this->storage = app('filesystem')->disk();
    }

    public function createRole(array $data, ?UploadedFile $image): Role {
        $data['image_path'] = $this->handleImageUpload($image, 'images/products');

        return $this->productRepository->create($data);
    }

    public function updateRole(Role $product, array $data, ?UploadedFile $image): Role {
        $this->handleImageDeletion($product->image_path);
        $data['image_path'] = $this->handleImageUpload($image, 'images/products');

        return $this->productRepository->update($product, $data);
    }

    public function deleteRole(Role $product): void {
        $this->handleImageDeletion($product->image_path);
        $this->productRepository->delete($product);
    }
}
