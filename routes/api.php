<?php

use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\BasicController;
use App\Http\Controllers\API\v1\ChatController;
use App\Http\Controllers\API\v1\PaymentController;
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


Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('slider', [BasicController::class, 'slider']);
    Route::get('videos', [BasicController::class, 'videos']);
    Route::get('packages', [BasicController::class, 'packages']);
    Route::get('profile', [BasicController::class, 'profile']);
    Route::get('registered_workshops', [BasicController::class, 'registered_workshop']);
    Route::get('workshops/{id?}', [BasicController::class, 'workshops']);

    //payment related
    Route::post('/generate-order', [PaymentController::class, 'gen_order']);
    Route::post('/fetch-payment', [PaymentController::class, 'fetch']);

    Route::post('/register-workshop', [BasicController::class, 'registerWorkshop']);
    Route::post('/update-user', [BasicController::class, 'update_user']);

    Route::post('/workshop-free', [BasicController::class, 'workshop_free']);
    Route::post('/package-free', [BasicController::class, 'package_free']);


    Route::post('/fno', [BasicController::class, 'fno']);

    Route::post('/wallet', [BasicController::class, 'wallet']);

    Route::get('chats/{page}', [ChatController::class, 'get']);
    Route::post('chats/send', [ChatController::class, 'store']);
    Route::get('chat-status', [ChatController::class, 'status']);
});
Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/send-signal', [ChatController::class, 'sendSignal']);
});





Route::get('chats/{page}', [ChatController::class, 'get']);
Route::post('chats/send', [ChatController::class, 'store']);
