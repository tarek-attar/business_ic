<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//? العمليات داخل الشات
Route::post('chat/createRoom', [ChatController::class, 'createRoom']);
Route::post('chat/addParticipant', [ChatController::class, 'addParticipant']);
Route::post('chat/removeParticipant', [ChatController::class, 'removeParticipant']);
Route::post('chat/startTexting', [ChatController::class, 'startTexting']);

Route::post('rooms', [ChatController::class, 'rooms']);
Route::post('newMessage/{roomId}', [ChatController::class, 'newMessage']);
Route::post('readAt/{roomId}', [ChatController::class, 'readAt']);

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
