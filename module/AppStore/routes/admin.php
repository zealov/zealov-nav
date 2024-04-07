<?php

use Illuminate\Support\Facades\Route;
use Module\AppStore\Admin\Controller\SpaController;


Route::get('app/{module}', SpaController::class);
Route::get('app/{module}/{id}', SpaController::class);

