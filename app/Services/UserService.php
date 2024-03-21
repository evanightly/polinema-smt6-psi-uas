<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\Services\HandlesImages;
use Illuminate\Http\UploadedFile;

class UserService {
    use HandlesImages;

    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->storage = app('filesystem')->disk();
    }

    public function createUser(array $data, ?UploadedFile $image): User {
        $data['image_path'] = $this->handleImageUpload($image, 'images/users');
        $user = $this->userRepository->create($data);

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user;
    }

    public function updateUser(User $user, array $data, ?UploadedFile $image): User {
        $this->handleImageDeletion($user->image_path);
        $data['image_path'] = $this->handleImageUpload($image, 'images/users');
        $user = $this->userRepository->update($user, $data);

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user;
    }

    public function deleteUser(User $user): User {
        $temp_user = $user;
        $this->handleImageDeletion($user->image_path);
        $this->userRepository->delete($user);
        return $temp_user;
    }
}
