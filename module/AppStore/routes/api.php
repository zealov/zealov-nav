<?php

use Illuminate\Support\Facades\Route;
use Module\AppStore\Api\Controller\AppStoreController;

Route::post('appStore/install', [AppStoreController::class, 'install']);
Route::post('appStore/upgrade', [AppStoreController::class, 'upgrade']);
Route::post('appStore/uninstall', [AppStoreController::class, 'uninstall']);
Route::post('appStore/enable', [AppStoreController::class, 'enable']);
Route::post('appStore/disable', [AppStoreController::class, 'disable']);
Route::post('appStore/all', [AppStoreController::class, 'all']);


