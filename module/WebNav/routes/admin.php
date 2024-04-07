<?php

use Illuminate\Support\Facades\Route;
use Module\WebNav\Admin\Controller\SpaController;
Route::get('home',SpaController::class);
Route::get('webnav/{module}', SpaController::class);
Route::get('webnav/{module}/{id}', SpaController::class);
Route::get('iframe/{module}', SpaController::class);

