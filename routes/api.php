<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupportAndHelpController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\CompleteServiceController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\WhoWeAreController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\CommonUnitController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PolicyTermController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\OurSupportController;
use App\Http\Controllers\TechCreativityController as TCC;


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
Route::get('/complete-services', [CompleteServiceController::class, 'apiIndex']);
Route::get('/fleets', [FleetController::class, 'apiIndex']);
Route::get('/sectors', [SectorController::class, 'apiIndex']);
Route::get('/customers', [CustomerController::class, 'apiIndex']);
Route::get('/who_we_are', [WhoWeAreController::class, 'apiIndex']);
Route::get('/trains', [TrainController::class, 'apiIndex']);
Route::get('/commons', [CommonUnitController::class, 'apiIndex']);
Route::get('/common/{name}', [CommonUnitController::class, 'apiShow']);

Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/services/{slug}', [ServiceApiController::class, 'show']);
Route::get('/settings', [SettingController::class, 'apiIndex']);
Route::get('/heros', [HeroController::class, 'apiIndex']);
Route::get('/videos', [VideoController::class, 'apiIndex']);

Route::get('/tech-creativity', [TCC::class, 'apiIndex']);
Route::get('/policy-terms', [PolicyTermController::class, 'apiIndex']);
Route::get('/postes', [BlogController::class, 'apiIndex']);
Route::get('/banners', [BannerController::class, 'apiIndex']);

Route::get('/about-us', [AboutUsController::class, 'apiIndex']);
Route::get('/certificates', [CertificateController::class, 'apiIndex']);
Route::get('/our-supports', [OurSupportController::class, 'apiIndex']);


