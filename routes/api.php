<?php

use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BorrowDeviceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\LaptopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// branch CRUD
Route::get('/branchs', [BranchController::class, 'index']);
Route::get('/branchs/{id}', [BranchController::class, 'show']);
Route::post('/branchs', [BranchController::class, 'store']);
Route::put('/branchs/{id}', [BranchController::class, 'update']);
Route::delete('/branchs/{id}', [BranchController::class, 'destroy']);

// borrow CRUD
Route::get('/borrows', [BorrowController::class, 'index']);
Route::get('/borrows/{id}', [BorrowController::class, 'show']);
Route::post('/borrows', [BorrowController::class, 'store']);
Route::put('/borrows/{id}', [BorrowController::class, 'update']);
Route::delete('/borrows/{id}', [BorrowController::class, 'destroy']);

// borrowDevice CRUD
Route::get('/borrowdevicesbyborrowid/{id}', [BorrowDeviceController::class, 'showByBorrowId']);
Route::post('/borrowdevicearrays', [BorrowDeviceController::class, 'storeArray']);
Route::put('/borrowdevices/{id}', [BorrowDeviceController::class, 'update']);
Route::put('/borrowdevicearrays', [BorrowDeviceController::class, 'updateArray']);

// laptop CRUD
Route::get('/laptops', [LaptopController::class, 'index']);
Route::get('/laptops/{id}', [LaptopController::class, 'show']);
Route::post('/laptops', [LaptopController::class, 'store']);
Route::post('/laptops/{id}', [LaptopController::class, 'update']);
Route::delete('/laptops/{id}', [LaptopController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
