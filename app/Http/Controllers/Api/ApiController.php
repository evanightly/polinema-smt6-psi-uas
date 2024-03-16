<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
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
     * @param Builder $modelClass
     * @param string $resourceClass
     * @param int $paginate, default 5
     * @return AnonymousResourceCollection
     */
    public function apiPaginateResponse($model, $resourceClass, $paginate = 5) {
        if (!class_exists($resourceClass)) {
            throw new InvalidArgumentException("Resource class {$resourceClass} does not exist.");
        }

        $items = $model->paginate($paginate);

        return $resourceClass::collection($items)->additional([

            // For table numbering purposes
            'firstItem' => $items->firstItem(),
        ]);
    }
}
