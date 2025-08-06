<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupportAndHelpController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\Api\ServiceApiController;
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

Route::post('/contacts', [ContactController::class,'store'])->name('api.contacts.store');
Route::get('/projects', [ProjectController::class, 'apiIndex']);
Route::get('/support-and-helps', [SupportAndHelpController::class, 'apiIndex']);
Route::get('/sustainabilities', [SustainabilityController::class, 'apiIndex']);

Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/services/{slug}', [ServiceApiController::class, 'show']);

