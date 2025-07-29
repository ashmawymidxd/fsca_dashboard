<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupportAndHelpController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('projects', ProjectController::class)->middleware('auth');
Route::resource('support-and-helps', SupportAndHelpController::class)->middleware('auth');
Route::resource('sustainabilities', SustainabilityController::class)->middleware('auth');

Route::resource('services', ServiceController::class)->middleware('auth');
Route::resource('services.categories', ServiceCategoryController::class);

Route::get('/servicesapi', [ServiceApiController::class, 'index']);
Route::get('/servicesapi/{slug}', [ServiceApiController::class, 'show']);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

Route::get('/icons', [PageController::class, 'icons'])->name('icons');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('contacts', ContactController::class)->except(['create', 'edit', 'update']);
    Route::post('contacts/{contact}/reply', [ContactController::class,'sendReply'])->name('contacts.reply');
});



require __DIR__.'/auth.php';

// disable registr
Route::get('/register', function () {
    return redirect()->route('login');
})->name('register')->middleware('guest');

