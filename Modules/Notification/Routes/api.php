<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\Api\V1\NotificationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('notifications', NotificationController::class)->names('notification');
});
