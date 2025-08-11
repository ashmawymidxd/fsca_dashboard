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
use App\Http\Controllers\CompleteServiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\trainController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CommonUnitController;

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

Route::get('/dashboard', [DashboardController::class,'index'])
    ->middleware(['auth', 'admin.permission:view-dashboard'])
    ->name('home');

Route::middleware(['auth','admin.permission:manage-profile'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Projects routes with individual permissions
Route::middleware(['auth', 'admin.permission:manage-projects'])->group(function () {
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::get('projects/{project}', [ProjectController::class, 'show'])
        ->middleware('admin.permission:view-projects')
        ->name('projects.show');
});

// Support and Help routes with individual permissions
Route::middleware(['auth', 'admin.permission:manage-support'])->group(function () {
    Route::resource('support-and-helps', SupportAndHelpController::class)->except(['show']);
    Route::get('support-and-helps/{support_and_help}', [SupportAndHelpController::class, 'show'])
        ->middleware('admin.permission:view-support')
        ->name('support-and-helps.show');
});

// Sustainability routes with individual permissions
Route::middleware(['auth', 'admin.permission:manage-sustainability'])->group(function () {
    Route::resource('sustainabilities', SustainabilityController::class)->except(['show']);
    Route::get('sustainabilities/{sustainability}', [SustainabilityController::class, 'show'])
        ->middleware('admin.permission:view-sustainability')
        ->name('sustainabilities.show');
});

// Services routes with individual permissions
Route::middleware(['auth', 'admin.permission:manage-services'])->group(function () {
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::get('services/{service}', [ServiceController::class, 'show'])
        ->middleware('admin.permission:view-services')
        ->name('services.show');
});

// Service Categories routes with individual permissions
Route::middleware(['auth', 'admin.permission:manage-service-categories'])->group(function () {
    Route::resource('services.categories', ServiceCategoryController::class)->except(['show']);
    Route::get('services/{service}/categories/{category}', [ServiceCategoryController::class, 'show'])
        ->middleware('admin.permission:view-service-categories')
        ->name('services.categories.show');
});

// Notifications routes with permissions
Route::group(['middleware' => ['auth', 'admin.permission:manage-notifications']], function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

Route::get('/icons', [PageController::class, 'icons'])
    ->middleware(['auth', 'admin.permission:view-icons'])
    ->name('icons');

// Contacts routes with permissions
Route::group(['middleware' => ['auth', 'admin.permission:manage-contacts']], function() {
    Route::resource('contacts', ContactController::class)->except(['create', 'edit', 'update', 'show']);
    Route::get('contacts/{contact}', [ContactController::class, 'show'])
    ->middleware('admin.permission:view-contacts')
    ->name('contacts.show');
    Route::post('contacts/{contact}/reply', [ContactController::class,'sendReply'])->name('contacts.reply');
});

// Complete Services Routes
Route::prefix('complete_services')->group(function () {
    Route::get('/', [CompleteServiceController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-complete-services'])
        ->name('complete_services.index');
    
    Route::resource('/', CompleteServiceController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-complete-services'])
        ->names('complete_services');
});

// Fleets Routes
Route::prefix('fleets')->group(function () {
    Route::get('/', [FleetController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-fleets'])
        ->name('fleets.index');
    
    Route::resource('/', FleetController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-fleets'])
        ->names('fleets');
});

// Sectors Routes
Route::prefix('sectors')->group(function () {
    Route::get('/', [SectorController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-sectors'])
        ->name('sectors.index');
    
    Route::resource('/', SectorController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-sectors'])
        ->names('sectors');
});

// Trains Routes
Route::prefix('trains')->group(function () {
    Route::get('/', [TrainController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-trains'])
        ->name('trains.index');
    
    Route::resource('/', TrainController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-trains'])
        ->names('trains');
});

// Common Units Routes
Route::prefix('common-units')->group(function () {
    Route::get('/', [CommonUnitController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-common-units'])
        ->name('common-units.index');
    
    Route::resource('/', CommonUnitController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-common-units'])
        ->names('common-units');
});

// Admins routes with permissions
Route::group(['middleware' => ['auth', 'admin.permission:manage-admins']], function () {
    Route::resource('admins', AdminsController::class)->except(['show']);
    Route::get('admins/{admin}', [AdminsController::class, 'show'])
        ->middleware('admin.permission:view-admins')
        ->name('admins.show');
});

// Permissions routes with permissions
Route::group(['middleware' => ['auth', 'admin.permission:manage-permissions']], function() {
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])
        ->middleware('admin.permission:view-permissions')
        ->name('permissions.show');
});

require __DIR__.'/auth.php';

// disable register
Route::get('/register', function () {
    return redirect()->route('login');
})->name('register')->middleware('guest');
