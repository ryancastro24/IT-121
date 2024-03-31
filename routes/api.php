<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post("/register",'registerUser')->name('user.register');
});





Route::post('/login', [AuthController::class, 'login'])->name("user.login");




Route::middleware(['auth:sanctum'])->group(function () {

    Route::controller(TaskController::class)->group(function () {
        Route::get("/tasks",'showTasks');
        Route::post('/tasks', 'storeTask')->name('task.store');
        Route::delete('/tasks/{id}','deleteTask');
        Route::put('/taskscompleted/{id}', 'taskCompleted')->name("task.complete");
        Route::post('/taskUpdate/{id}', 'taskUpdate')->name("task.taskUpdate");
    });
    

    Route::controller(AuthController::class)->group(function () {
       
        Route::post('/logout', 'logout')->name('logout');
    });


});



Route::fallback(function (Request $request) {
    return response()->json(['error' => 'Unauthenticated.'], 401);
});
