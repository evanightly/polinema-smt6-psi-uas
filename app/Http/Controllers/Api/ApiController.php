<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;
use InvalidArgumentException;

class ApiController extends BaseController {
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Custom paginate response designed to work with api resources.
     *
     * @param string $modelClass
     * @param string $resourceClass
     * @param int $paginate, default 5
     * @return AnonymousResourceCollection
     */
    public function apiPaginateResponse(string $modelClass, string $resourceClass, $paginate = 5): AnonymousResourceCollection {
        $modelInstance = app($modelClass);
        if (!class_exists($resourceClass)) {
            throw new InvalidArgumentException("Resource class {$resourceClass} does not exist.");
        }

        $items = $modelInstance->paginate($paginate);

        return $resourceClass::collection($items)->additional([
            'firstItem' => $items->firstItem(),
        ]);
    }
}
