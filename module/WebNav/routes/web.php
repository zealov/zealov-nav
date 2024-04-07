<?php

use Illuminate\Support\Facades\Route;
use Module\WebNav\Web\Controller\IndexController;

Route::get('', [IndexController::class,'index']);
