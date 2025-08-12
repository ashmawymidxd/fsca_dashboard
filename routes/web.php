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
use App\Http\Controllers\WhoWeAreController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CommonUnitController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VideoController;

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
    // Index route
    Route::get('/', [CompleteServiceController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-complete-services'])
        ->name('complete_services.index');

    // Resource routes with proper path
    Route::resource('service', CompleteServiceController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-complete-services'])
        ->names('complete_services')
        ->parameters(['service' => 'completeService']);
});

// Fleets Routes
Route::prefix('fleets')->group(function () {
    // Index route
    Route::get('/', [FleetController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-fleets'])
        ->name('fleets.index');

    // Resource routes with proper path
    Route::resource('fleet', FleetController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-fleets'])
        ->names('fleets')
        ->parameters(['fleet' => 'fleet']); // Explicit parameter naming
});

// Customers Routes
Route::prefix('customers')->group(function () {
    // Index route
    Route::get('/', [CustomerController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-customers'])
        ->name('customers.index');

    // Resource routes with proper path
    Route::resource('customer', CustomerController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-customers'])
        ->names('customers')
        ->parameters(['customer' => 'customer']); // Explicit parameter naming

    // API route
    Route::get('/api/customers', [CustomerController::class, 'apiIndex']);
});

// Sectors Routes
Route::prefix('sectors')->group(function () {
    // Index route
    Route::get('/', [SectorController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-sectors'])
        ->name('sectors.index');

    // Resource routes with proper path
    Route::resource('sector', SectorController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-sectors'])
        ->names('sectors')
        ->parameters(['sector' => 'sector']); // Explicit parameter name
});

// Who We Are Routes
Route::prefix('who_we_are')->group(function () {
    // Index route
    Route::get('/', [WhoWeAreController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-who-we-are'])
        ->name('who_we_are.index');

    // Resource routes with proper path
    Route::resource('entry', WhoWeAreController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-who-we-are'])
        ->names('who_we_are')
        ->parameters(['entry' => 'whoWeAre']); // Explicit parameter name
});

// Trains Routes
Route::prefix('trains')->group(function () {
    // Index route
    Route::get('/', [TrainController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-trains'])
        ->name('trains.index');

    // Resource routes with proper path
    Route::resource('train', TrainController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-trains'])
        ->names('trains')
        ->parameters(['train' => 'train']); // Explicit parameter binding
});

// Common Units Routes
Route::prefix('common-units')->group(function () {
    // Index route
    Route::get('/', [CommonUnitController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-common-units'])
        ->name('common-units.index');

    // Resource routes with proper path
    Route::resource('unit', CommonUnitController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-common-units'])
        ->names('common-units')
        ->parameters(['unit' => 'commonUnit']);
});

// Hero Section Routes
Route::prefix('heroes')->group(function () {
    // Index route
    Route::get('/', [HeroController::class, 'index'])
        ->middleware(['auth', 'admin.permission:view-heroes'])
        ->name('heroes.index');

    // Resource routes with proper path
    Route::resource('section', HeroController::class)
        ->except(['index'])
        ->middleware(['auth', 'admin.permission:manage-heroes'])
        ->names('heroes')
        ->parameters(['section' => 'hero']);
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

// settings routes with permissions
Route::group(['middleware' => ['auth']], function() {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')
        ->middleware('admin.permission:view-settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update')
        ->middleware('admin.permission:manage-settings');
});
// videos outes with permissions
Route::resource('videos', VideoController::class)->middleware(['auth','permission:manage-videos']);

require __DIR__.'/auth.php';

// disable register
Route::get('/register', function () {
    return redirect()->route('login');
})->name('register')->middleware('guest');
