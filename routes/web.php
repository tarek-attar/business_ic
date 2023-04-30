<?php

use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatMessageTextController;
use App\Http\Controllers\Admin\GroupChatsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\ChatMessageController;
use App\Http\Controllers\Admin\FreelancerController;
use App\Http\Controllers\Admin\FreelancerActiveController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/rooms', [ChatController::class, 'rooms']);

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {


    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
        Route::get('/chat', function () {
            return Inertia::render('Chat/container');
        })->name('chat');
    });

    Route::middleware('auth:sanctum')->get('/chat/rooms', [ChatController::class, 'rooms']);
    Route::middleware('auth:sanctum')->get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
    Route::middleware('auth:sanctum')->post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage']);


    // روابط اللوحة

    Route::prefix('admin')->name('admin.')->middleware('auth', 'check_user')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('categories', CategoryController::class);
        Route::resource('jobs', JobController::class);
        Route::resource('chats', ChatMessageTextController::class);
        Route::resource('group_chats', ChatMessageController::class);
        Route::resource('payments', PaymentController::class);
        Route::get('users/edituser{id}', [UserController::class, 'edit'])->name('edituser');
        Route::resource('admins', AdminsController::class);
        Route::resource('admin_notifications', AdminNotificationController::class);
        Route::resource('users', UserController::class);
        Route::get('users/createfreelancer', [UserController::class, 'createfreelancer'])->name('users.createfreelancer');
        Route::post('users/storefreelancer/{id}', [UserController::class, 'storefreelancer'])->name('users.storefreelancer');
        Route::resource('freelancers', FreelancerController::class);
        Route::resource('freelancersactive', FreelancerActiveController::class);

        Route::post('ajax_search', [UserController::class, 'ajax_search'])->name('ajax_search_ID');
    });

    Route::prefix('admin')->name('admin.')->middleware('auth', 'check_user', 'check_role')->group(function () {
        Route::get('user_upgrade/{id}', [UserController::class, 'upgrade'])->name('upgrade');
        Route::post('user_delete/{id}', [UserController::class, 'destroy'])->name('user_delete');
    });
});
