<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);


Route::post('upload/images', [\App\Http\Controllers\AuthController::class, 'uploadImage']);
Route::get('/avatar/{filename}', [\App\Http\Controllers\AuthController::class, 'getImage']);

Route::post('upload/image/instrument', [\App\Http\Controllers\InstrumentController::class, 'uploadImage']);
Route::get('/instrument/image/{filename}', [\App\Http\Controllers\InstrumentController::class, 'getImage']);

Route::post('upload/images/instrument', [\App\Http\Controllers\ImageController::class, 'uploadImage']);
Route::get('/instrument/images/{filename}', [\App\Http\Controllers\ImageController::class, 'getImage']);
Route::delete('/instrument/images/delete/{filename}', [\App\Http\Controllers\ImageController::class, 'deleteImage']);
Route::post('user/images', [\App\Http\Controllers\ImageController::class, 'userImages']);

Route::get('user/{id}', [\App\Http\Controllers\AuthController::class, 'getUser']);

Route::post('rate/instruments', [\App\Http\Controllers\StarsInstrumentController::class, 'rate']);
Route::post('stars/instruments', [\App\Http\Controllers\StarsInstrumentController::class, 'editStars']);

Route::get('images/{id}', [\App\Http\Controllers\ImageController::class, 'getAllImages']);


Route::post('update/user/{id}', [\App\Http\Controllers\AuthController::class, 'updateUser']);
Route::post('update/user/image/{id}', [\App\Http\Controllers\AuthController::class, 'updateUserImage']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::delete('delete/user/{id}', [\App\Http\Controllers\AuthController::class, 'deleteUser']);
    Route::post('user/info', [\App\Http\Controllers\AuthController::class, 'userInfo']);
    Route::post('chat/info', [\App\Http\Controllers\ChatController::class, 'showUsers']);
    Route::post('send/message', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
    Route::post('read/message', [\App\Http\Controllers\ChatController::class, 'readMessages']);
    Route::post('chat/create', [\App\Http\Controllers\ChatDetailsController::class, 'createChat']);
    Route::post('instrument/info/edit', [\App\Http\Controllers\InstrumentController::class, 'instrumentInfoEdit']);

});

Route::get('instruments', [\App\Http\Controllers\InstrumentController::class, 'showAllInstruments']);
Route::get('instruments/{id}', [\App\Http\Controllers\InstrumentController::class, 'showOneInstrument']);
Route::post('add/instrument', [\App\Http\Controllers\InstrumentController::class, 'createInstrument']);
Route::post('update/instrument/{id}', [\App\Http\Controllers\InstrumentController::class, 'updateInstrument']);
Route::post('update/instrument/image/{id}', [\App\Http\Controllers\InstrumentController::class, 'updateInstrumentImage']);
Route::delete('delete/instrument/{id}', [\App\Http\Controllers\InstrumentController::class, 'deleteInstrument']);
Route::post('comments/instrument', [\App\Http\Controllers\InstrumentController::class, 'instrumentComment']);

Route::get('myinstrument/info/{id}', [\App\Http\Controllers\InstrumentController::class, 'myInstrumentCard']);
Route::get('info/instruments', [\App\Http\Controllers\InstrumentController::class, 'instrumentCard']);

Route::post('user/instruments', [\App\Http\Controllers\InstrumentController::class, 'userInstruments']);

Route::post('instrument/images', [\App\Http\Controllers\ImageController::class, 'uploadImages']);



Route::post('instrument/info', [\App\Http\Controllers\InstrumentController::class, 'instrumentInfo']);


Route::get('rentedInstrument', [\App\Http\Controllers\RentedInstrumentController::class, 'showAllRentedInstruments']);
Route::get('rentedInstruments/{id}', [\App\Http\Controllers\RentedInstrumentController::class, 'showOneRentedInstrument']);
Route::post('rent/instrument', [\App\Http\Controllers\RentedInstrumentController::class, 'rentInstrument']);
Route::put('update/rentedInstrument/{id}', [\App\Http\Controllers\RentedInstrumentController::class, 'updateRentedInstrument']);
Route::delete('delete/rentedInstrument/{id}', [\App\Http\Controllers\RentedInstrumentController::class, 'deleteRentedInstrument']);
Route::get('dates/rentedInstrument/{id}', [\App\Http\Controllers\RentedInstrumentController::class, 'datesRentedInstrument']);


Route::post('comment/instrument', [\App\Http\Controllers\CommentsInstrumentController::class, 'createComment']);




Route::post('search/user', [\App\Http\Controllers\AuthController::class, 'search']);
Route::post('search/instrument', [\App\Http\Controllers\InstrumentController::class, 'search']);







