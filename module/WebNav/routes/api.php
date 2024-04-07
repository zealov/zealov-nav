<?php

use Illuminate\Support\Facades\Route;
use Module\WebNav\Api\Controller\CategoryController;
use Module\WebNav\Api\Controller\ConfigController;
use Module\WebNav\Api\Controller\FileSystemController;
use Module\WebNav\Api\Controller\NavigationController;

//导航
Route::get('WebNav/navigation', [NavigationController::class, 'index']);
Route::get('WebNav/navigation/{id}', [NavigationController::class, 'show']);
Route::put('WebNav/navigation/{id}', [NavigationController::class, 'update']);
Route::post('WebNav/navigation', [NavigationController::class, 'store']);
Route::post('WebNav/navigation/updateSort', [NavigationController::class, 'updateSort']);
Route::delete('WebNav/navigation/{id}', [NavigationController::class, 'destroy']);

//分类
Route::get('WebNav/category', [CategoryController::class, 'index']);
Route::get('WebNav/category/{id}', [CategoryController::class, 'show']);
Route::put('WebNav/category/{id}', [CategoryController::class, 'update']);
Route::post('WebNav/category', [CategoryController::class, 'store']);
Route::post('WebNav/category/updateSort', [CategoryController::class, 'updateSort']);
Route::delete('WebNav/category/{id}', [CategoryController::class, 'destroy']);

//站点配置
Route::post('WebNav/config', [ConfigController::class, 'store']);
Route::put('WebNav/config/{id}', [ConfigController::class, 'update']);
Route::get('WebNav/config', [ConfigController::class, 'index']);
Route::get('WebNav/config/group', [ConfigController::class, 'group']);
Route::get('WebNav/config/{id}', [ConfigController::class, 'show']);

//文件上传
Route::post('WebNav/file/upload', [FileSystemController::class, 'upload']);

