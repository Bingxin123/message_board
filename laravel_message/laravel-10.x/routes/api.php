<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/hello', [\App\Http\Controllers\HelloWorldController::class, 'getHello']);
Route::get('/bookcreate', [\App\Http\Controllers\PostController::class, 'create']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/Register',[AuthController::class, 'register']);// 使用者註冊
    Route::post('/Login',[AuthController::class, 'login']); // 使用者登入 (回傳 JWT token 及使用者資訊)
    Route::get('/User-Profile',[AuthController::class, 'userProfile']);// 以 JWT token 取得使用者資訊
    Route::post('/Refresh',[AuthController::class, 'refresh']);// 更新 JWT token
    Route::post('/Logout',[AuthController::class, 'logout']); 
    Route::post('/CreateComment',[CommentController::class, 'Create']);// 使用者登出，移除 JWT token
    Route::get('/ReadUserComment',[CommentController::class, 'ReadUser']);
    Route::post('/UpdateComment/{id}',[CommentController::class, 'Update']);
    Route::delete('/DeleteComment/{id}',[CommentController::class, 'Destroy']);
    Route::post('/SearchUserComment',[CommentController::class,'SearchUser']);
    Route::get('/ReadAllComment',[CommentController::class,'ReadAll']);
    Route::post('/SearchAllComment',[CommentController::class,'SearchAll']);
});