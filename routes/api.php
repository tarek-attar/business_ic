<?php

use App\Http\Controllers\API\Api_UserController;
use App\Http\Controllers\API\Api_JobController;
use App\Http\Controllers\API\Api_CategoryController;
use App\Http\Controllers\API\Api_AuthController;
use App\Http\Controllers\API\Api_GalleryController;
use App\Http\Controllers\API\Api_ChatController;
use App\Http\Controllers\API\Api_Tell_meController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return '$request->user()';
});


//? العمليات داخل الشات

/* Route::post('chat/createRoom', [ChatController::class, 'createRoom']);
Route::post('chat/addParticipant', [ChatController::class, 'addParticipant']);
Route::post('chat/removeParticipant', [ChatController::class, 'removeParticipant']);
Route::post('chat/startTexting', [ChatController::class, 'startTexting']);

Route::post('rooms', [ChatController::class, 'rooms']);
Route::post('newMessage/{roomId}', [ChatController::class, 'newMessage']);
Route::post('readAt/{roomId}', [ChatController::class, 'readAt']); */


// API for chating
Route::middleware('auth:sanctum')->group(function () {
    Route::post('rooms', [Api_ChatController::class, 'rooms']);
    Route::post('chat/startTexting ', [Api_ChatController::class, 'startTexting']);
    Route::post('chat/startTextingTechnicalSupport ', [Api_ChatController::class, 'startTextingTechnicalSupport']);
    Route::post('chat/createRoom', [Api_ChatController::class, 'createRoom']);
    Route::post('chat/addParticipant', [Api_ChatController::class, 'addParticipant']);
    Route::post('chat/removeParticipant', [Api_ChatController::class, 'removeParticipant']);
    Route::post('chat/messages', [Api_ChatController::class, 'messages']);
    Route::post('chat/newMessage', [Api_ChatController::class, 'newMessage']);
});
//Route::post('readAt/{roomId}', [Api_ChatController::class, 'readAt']);

// Add freelancer to Tell-Me 
Route::post('tellme/add', [Api_Tell_meController::class, 'add_new_freelancer_to_tell_me'])->middleware('auth:sanctum');
Route::post('tellme/show', [Api_Tell_meController::class, 'show'])->middleware('auth:sanctum'); // يتحكم بهذا الادمن فقط 
Route::post('tellme/update', [Api_Tell_meController::class, 'update'])->middleware('auth:sanctum');
Route::post('tellme/delete', [Api_Tell_meController::class, 'delete'])->middleware('auth:sanctum');

/*
Route::middleware('auth:sanctum')->group(function () {
    Route::get('conversations', [ConversationController::class, 'index']);
    Route::get('conversations/{conversation}', [ConversationController::class, 'show']);
    Route::post('conversations/{conversation}/participants', [ConversationController::class, 'addParticipant']);
    Route::delete('conversations/{conversation}/participants', [ConversationController::class, 'removeParticipant']);

    Route::get('conversations/{id}/messages', [MessagesController::class, 'index']);
    Route::post('messages', [MessagesController::class, 'store']);
    Route::delete('messages/{id}', [MessagesController::class, 'destroy']);
}); */

Route::middleware('auth:sanctum', 'check_password')->group(function () {

    Route::post('job', [Api_JobController::class, 'index']);
    Route::post('getOneJob', [Api_JobController::class, 'getOneJob']);
    Route::post('job/createJop', [Api_JobController::class, 'createJop']);
    Route::post('job/updateJop/{id}', [Api_JobController::class, 'updateJop']);
    Route::delete('job/destroyJop/{id}', [Api_JobController::class, 'destroy']);

    Route::post('user', [Api_UserController::class, 'index']);
    Route::post('admin', [Api_UserController::class, 'admin']);
    Route::post('getOneUser', [Api_UserController::class, 'getOneUser']);
    Route::post('user/createUser', [Api_UserController::class, 'createUser']);
    Route::post('user/updateUser', [Api_UserController::class, 'updateUser']);
    Route::delete('user/destroyUser/{id}', [Api_UserController::class, 'destroyUser']);
    Route::post('new_freelancer/{id}', [Api_UserController::class, 'new_freelancer']);

    Route::post('category', [Api_CategoryController::class, 'index'])->middleware('api_check_role');
    Route::post('category/createCategory', [Api_CategoryController::class, 'createCategory'])->middleware('api_check_role');
    Route::post('category/updateCategory/{id}', [Api_CategoryController::class, 'updateCategory'])->middleware('api_check_role');
    Route::delete('category/destroyCategory/{id}', [Api_CategoryController::class, 'destroyCategory'])->middleware('api_check_role');

    Route::post('gallery', [Api_GalleryController::class, 'index']);
    Route::post('getOneGallery', [Api_GalleryController::class, 'getOneGallery']);
    Route::post('gallery/createGallery', [Api_GalleryController::class, 'createGallery']);
    Route::post('gallery/updateGallery/{id}', [Api_GalleryController::class, 'updateGallery']);
    Route::delete('gallery/destroyGallery/{id}', [Api_GalleryController::class, 'destroyGallery']);
});


Route::post('logout', [Api_AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('login', [Api_AuthController::class, 'login']);
Route::post('register', [Api_AuthController::class, 'register']);
