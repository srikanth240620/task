<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;


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


Route::get('get_project',[ProjectController::class,'get_project']);
Route::post('add_project',[ProjectController::class,'add_project']);
Route::post('edit_project',[ProjectController::class,'edit_project']);
Route::post('delete_project',[ProjectController::class,'delete_project']);
Route::post('view_project',[ProjectController::class,'view_project']);


Route::get('get_task',[UserController::class,'get_task']);
Route::post('add_task',[UserController::class,'add_task']);
Route::post('edit_task',[UserController::class,'edit_task']);
Route::post('delete_task',[UserController::class,'delete_task']);
Route::post('view_task',[UserController::class,'view_task']);

Route::get('project_dt',[UserController::class,'project_dt']);






