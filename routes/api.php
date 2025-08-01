<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UsageController;
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

// Health check route
Route::get('/', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()
    ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('info', [AuthController::class, 'info']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('/tools/paginate', [ToolController::class, 'paginate']);
    Route::get('/consumables/paginate', [ConsumableController::class, 'paginate']);

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('consumables', ConsumableController::class);
    Route::apiResource('tools', ToolController::class);

    // Paginated routes for tools and consumables

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    Route::get('/usages', [UsageController::class, 'index']);
    Route::get('/usages/{id}', [UsageController::class, 'show']);
    Route::post('/usages', [UsageController::class, 'store']);
    Route::delete('/usages/{id}', [UsageController::class, 'destroy']);

    Route::get('/loans', [LoanController::class, 'index']);
    Route::get('/loans/{id}', [LoanController::class, 'show']);
    Route::post('/loans', [LoanController::class, 'store']);
    Route::put('/loans/{id}', [LoanController::class, 'update']); // return
    Route::delete('/loans/{id}', [LoanController::class, 'destroy']); // delete loan


});
