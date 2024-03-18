<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Notification\DeleteNotificationRequest;
use App\Http\Requests\Notification\MarkAsFinishNotificationRequest;
use App\Models\Product;
use App\Models\Supplier;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ApiNotificationController extends ApiController {

    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }

    public function index($id) {
        return $this->notificationRepository->get($id);
    }

    public function markAsFinish(MarkAsFinishNotificationRequest $request) {
        $this->notificationRepository->delete($request);
        return response()->noContent();
    }
}
