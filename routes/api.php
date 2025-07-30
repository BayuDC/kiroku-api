<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World',
    ]);
});

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('info', [AuthController::class, 'info']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('consumables', ConsumableController::class);
    Route::apiResource('tools', ToolController::class);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    // Route::get('/usages');
    // Route::get('/usages/:id');
    // Route::post('/usages');
    // Route::delete('/usages');

    // Route::get('/loans');
    // Route::get('/loans/:id');
    // Route::post('/loans');
    // Route::patch('/loans/:id'); // return
    // Route::delete('/loans/:id'); // delete loan


});
