<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CostcenterController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\TravelitineraryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SignatureController;
use App\Models\Travelitinerary;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//pagaidu routs pusgatavām lapām un testiem
Route::get('/underconstruction', function () {
    return view('/underconstruction');
});

// autentifikācijas routi
Auth::routes();

// sākuma lapa
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//useru saraksts, pdf eksporta tests
Route::get('/employees/index', [EmployeeController::class, 'showEmployees'])->name('employees.index');
Route::get('/employee/pdf', [EmployeeController::class, 'createPDF']);
Route::get('/employee/edit/{id}', [EmployeeController::class, 'editemployee']);
Route::post('/employee/update/{id}', [EmployeeController::class, 'updateemployee']);
Route::get('/employee/delete/{id}', [EmployeeController::class, 'deleteemployee']);

//resursu routspostiem
Route::resource('posts', PostController::class)->middleware('auth');

// routi izmaksu centriem 
// costcenters/index ir index.php fails views/costcenters mapē
// allcostcenters ir metodes nosaukums kontrolierī un costcenters.index ir routa nosaukums 
// uz kuru atsaucas no layouta faila views/layouts/app.blade.php
Route::get('costcenters/index', [CostcenterController::class, 'allcostcenters'])->name('costcenters.index');
Route::post('costcenters/add', [CostcenterController::class, 'addcostcenter'])->name('store.costcenter');
Route::get('/costcenter/edit/{id}', [CostcenterController::class, 'editcostcenter']);
Route::post('/costcenter/update/{id}', [CostcenterController::class, 'updatecostcenter']);
Route::get('/costcenter/delete/{id}', [CostcenterController::class, 'deletecostcenter']);
Route::get('/costcenters/search/', [CostcenterController::class, 'search'])->name('costcenter.search');

// routi automašīnām
Route::get('cars/index', [CarController::class, 'allcars'])->name('cars.index')->middleware('auth');
Route::get('cars/create', [CarController::class, 'createcars'])->name('cars.create');
Route::post('cars/add', [CarController::class, 'addcar'])->name('store.car');
Route::get('/car/edit/{id}', [CarController::class, 'editcar']);
Route::post('/car/update/{id}', [CarController::class, 'updatecar']);
Route::get('/car/delete/{id}', [CarController::class, 'deletecar']);
Route::get('/cars/search/', [CarController::class, 'search'])->name('car.search');

// routi ceļazīmēm
Route::get('itineraries/index', [TravelitineraryController::class, 'allitineraries'])->name('itineraries.index');
Route::get('itineraries/create', [TravelitineraryController::class, 'createitineraries'])->name('itineraries.create');
Route::post('itineraries/add', [TravelitineraryController::class, 'additineraries'])->name('store.itinerary');
Route::get('/itinerary/edit/{id}', [TravelitineraryController::class, 'edititinerary']);
Route::post('/itinerary/update/{id}', [TravelitineraryController::class, 'updateitinerary']);
Route::get('/itinerary/delete/{id}', [TravelitineraryController::class, 'deleteitinerary']);
Route::get('/itinerary/show/{id}', [TravelitineraryController::class, 'show'])->name('itineraries.show');
Route::get('/itineraries/search/', [TravelitineraryController::class, 'search'])->name('itineraries.search');


//routi braucieniem
Route::get('journeys/index', [JourneyController::class, 'alljourneys'])->name('journeys.index');
Route::post('journeys/add', [JourneyController::class, 'addjourneys'])->name('store.journey');
Route::get('/journey/delete/{id}', [JourneyController::class, 'deletejourney']);

//routi testa signature pad
Route::get('signatures/signature-pad', [SignatureController::class, 'index'])->name('signatures.index');
Route::post('signatures/signature-pad', [SignatureController::class, 'store'])->name('signature_pad.store');