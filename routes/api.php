<?php

use Hladenkyi\Editor\Http\Controllers\TinyUploadController;

Route::post('{resource}/image-manager', [TinyUploadController::class, 'store']);
Route::delete('{resource}/image-manager', [TinyUploadController::class, 'destroy']);
