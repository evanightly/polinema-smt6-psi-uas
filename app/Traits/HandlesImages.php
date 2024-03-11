<?php

namespace App\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

trait HandlesImages {
    protected Filesystem $storage;

    public function __construct(FileSystem $storage) {
        $this->storage = $storage;
    }

    /**
     * Handle image upload.
     *
     * @param UploadedFile|null $image The image to be uploaded.
     * @param string $path The path where the image should be stored, relative to 'public/storage'., e.g. 'images/products'. or 'images/users'.
     * @return string|null The path of the stored image, or null if no image was provided.
     */
    protected function handleImageUpload(?UploadedFile $image, string $path): ?string {
        if ($image) {
            return $image->store($path, 'public');
        }

        return null;
    }

    /**
     * Handle image deletion.
     *
     * @param string $imagePath The path of the image to be deleted, relative to 'public/storage'.
     */
    protected function handleImageDeletion(?string $imagePath): void {
        if ($imagePath) {
            $this->storage->delete('public/' . $imagePath);
        }
    }
}
