<?php
use Illuminate\Support\Facades\Route;


Route::get('login',[\Zealov\Controllers\Admin\SpaController::class,'index']);
Route::get('personal',[\Zealov\Controllers\Admin\SpaController::class,'index']);


