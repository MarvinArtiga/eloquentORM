<?php

use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;

// Menu items CRUD
Route::apiResource('menu-items', MenuItemController::class);

// Filter by category
Route::get('menu-items/category/{category}', [MenuItemController::class, 'byCategory']);
