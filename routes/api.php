<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelReviewController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
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

Route::post('/login' , [UserController::class , 'login']);

Route::post('room/add' , [RoomController::class , 'store']);
Route::group(['middleware' => 'auth:sanctum'] , function () {
    ////////------- Secured Room Routes  ---------////////
    Route::post('room/{room?}/edit' , [RoomController::class , 'edit']);
    Route::post('room/{room?}/update' , [RoomController::class , 'update']);
});

////////-------  User Routes  ---------////////
Route::prefix('/user')->group(function(){
    Route::post('/add' , [UserController::class , 'store']);
    Route::get('/' , [UserController::class , 'index']);
    Route::get('/{user}' , [UserController::class , 'show']);
    Route::post('/{user?}/edit' , [UserController::class , 'edit']);
    Route::post('/{user?}/update' , [UserController::class , 'update']);
    Route::post('/{user?}/destroy' , [UserController::class , 'destroy']);
});


////////-------  Room Routes  ---------////////
Route::get('room/{room}' , [RoomController::class , 'show']);
Route::get('room/' , [RoomController::class , 'index']);
Route::post('room/{room?}/destroy' , [RoomController::class , 'destroy']);

////////-------  City Routes  ---------////////
Route::prefix('/city')->group(function () {
    Route::get('/' , [CityController::class , 'index']);
    Route::post('/add' , [CityController::class , 'store']);
    Route::get('/{city}' , [CityController::class , 'show']);
    Route::post('/{city}/edit' , [CityController::class , 'edit']);
    Route::post('/{city}/update' , [CityController::class , 'update']);
    Route::delete('/{city}/destroy' , [CityController::class , 'destroy']);
});


////////-------  Hotel Routes  ---------////////
Route::prefix('/hotel')->group(function(){
    Route::post('/add' , [HotelController::class , 'store']);
    Route::get('/{hotel?}' , [HotelController::class , 'show']);
    Route::post('/{hotel?}/edit' , [HotelController::class , 'edit']);
    Route::post('/{hotel?}/update' , [HotelController::class , 'update']);
    Route::delete('/{hotel?}/destroy' , [HotelController::class , 'destroy']);
});

////////-------  Amenity Routes  ---------////////
Route::prefix('/amenity')->group(function(){
    Route::post('/add' , [AmenityController::class , 'store']);
    Route::get('/' ,  [AmenityController::class , 'index']);
    Route::get('/{amenity}' , [AmenityController::class , 'show']);
    Route::post('/{amenity}/edit' , [AmenityController::class , 'edit']);
    Route::post('/{amenity}/update' , [AmenityController::class , 'update']);
    Route::post('/{amenity}/destroy' , [AmenityController::class , 'destroy']);
});

////////-------  Hotel Reviews Routes  ---------////////
Route::prefix('/hotel-review')->group(function () {
    Route::get('/' , [HotelReviewController::class , 'index']);
    Route::post('/add' , [HotelReviewController::class , 'store']);
    Route::get('/{hotel_review}' , [HotelReviewController::class , 'show']);
    Route::post('/{hotel_review}/edit' , [HotelReviewController::class , 'edit']);
    Route::post('/{hotel_review}/update' , [HotelReviewController::class , 'update']);
    Route::delete('/{hotel_review}/destroy' , [HotelReviewController::class , 'destroy']);
});

////////-------  Car Routes  ---------////////
Route::prefix('/car')->group(function () {
    Route::get('/' , [CarController::class , 'index']);
    Route::post('/add' , [CarController::class , 'store']);
    Route::get('/{car}' , [CarController::class , 'show']);
    Route::post('/{car}/edit' , [CarController::class , 'edit']);
    Route::post('/{car}/update' , [CarController::class , 'update']);
    Route::delete('/{car}/destroy' , [CarController::class , 'destroy']);
    Route::get('/{carId}/sub-images/show' , [CarController::class , 'showSubImages']);
    Route::post('/{carId}/sub-images/add' , [CarController::class , 'addSubImages']);
    Route::post('/{carId}/sub-images/delete' , [CarController::class , 'deleteSubImages']);
});

////////-------  Package Routes  ---------////////
Route::prefix('/package')->group(function () {
    Route::get('/' , [PackageController::class , 'index']);
    Route::post('/add' , [PackageController::class , 'store']);
    Route::get('/{package}' , [PackageController::class , 'show']);
    Route::post('/{package}/edit' , [PackageController::class , 'edit']);
    Route::post('/{package}/update' , [PackageController::class , 'update']);
    Route::delete('/{package}/destroy' , [PackageController::class , 'destroy']);
});

// Route::get('regx' , [UserController::class , 'regx']);
