<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TurbineController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\InspectionController;


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


// Route for displaying the index page (list of turbines)
Route::get('/turbines', [TurbineController::class, 'index'])->name('turbines.index');
// Route for storing a new turbine
Route::post('/turbines', [TurbineController::class, 'store'])->name('turbines.store');
// Route for updating an existing turbine
Route::put('/turbines/{turbine}', [TurbineController::class, 'update'])->name('turbines.update');
// Route for deleting a turbine
Route::delete('/turbines/{turbine}', [TurbineController::class, 'destroy'])->name('turbines.destroy');

// Route for storing a new component
Route::post('/components', [ComponentController::class, 'store'])->name('components.store');
// Route for updating an existing component
Route::put('/components/{component}', [ComponentController::class, 'update'])->name('components.update');
// Route for deleting a component
Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy');

// Route for storing a new inspection
Route::post('/inspections', [InspectionController::class, 'store'])->name('inspections.store');
// Route for updating an existing inspection
Route::put('/inspections/{inspection}', [InspectionController::class, 'update'])->name('inspections.update');
// Route for deleting an inspection
Route::delete('/inspections/{inspection}', [InspectionController::class, 'destroy'])->name('inspections.destroy');
