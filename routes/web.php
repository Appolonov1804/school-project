<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/teachers', [\App\Http\Controllers\MainController::class, 'main'])->name('teachers.index'); 

Route::get('/teachers/create', [\App\Http\Controllers\MainController::class, 'create'])->name('teachers.create'); 
Route::post('/teachers', [\App\Http\Controllers\MainController::class, 'store'])->name('teachers.store'); 
Route::get('/teachers/{teacher}', [\App\Http\Controllers\MainController::class, 'show'])->name('teachers.show'); 
Route::get('/teachers/{teacher}/edit', [\App\Http\Controllers\MainController::class, 'edit'])->name('teachers.edit');
Route::patch('/teachers/{teacher}', [\App\Http\Controllers\MainController::class, 'update'])->name('teachers.update');
Route::delete('/teachers/{teacher}', [\App\Http\Controllers\MainController::class, 'destroy'])->name('teachers.delete');

Route::get('/teachers/update', [\App\Http\Controllers\MainController::class, 'update']); 

Route::get('/teachers/delete', [\App\Http\Controllers\MainController::class, 'delete']); 

Route::get('/rosters', [\App\Http\Controllers\RosterController::class, 'roster'])->name('rosters.rosters');
Route::get('/rosters/create', [\App\Http\Controllers\RosterController::class, 'create'])->name('rosters.create');
Route::post('/rosters', [\App\Http\Controllers\RosterController::class, 'store'])->name('rosters.store');
Route::get('/rosters/{roster}', [\App\Http\Controllers\RosterController::class, 'show'])->name('rosters.show');
Route::get('/rosters/{roster}/edit', [\App\Http\Controllers\RosterController::class, 'edit'])->name('rosters.edit');
Route::patch('/rosters/{roster}', [\App\Http\Controllers\RosterController::class, 'update'])->name('rosters.update');
Route::delete('/rosters/{roster}', [\App\Http\Controllers\RosterController::class, 'destroy'])->name('rosters.delete');

// Route::get('/rosters/update', [\App\Http\Controllers\RosterController::class, 'update']); 

Route::get('/rosters/delete', [\App\Http\Controllers\RosterController::class, 'delete']); 


Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'report'])->name('reports.reports'); 
Route::get('/reports/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create'); 
Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store'); 
Route::get('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'show'])->name('reports.show'); 
Route::get('/reports/{report}/edit', [\App\Http\Controllers\ReportController::class, 'edit'])->name('reports.edit'); 
Route::patch('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'update'])->name('reports.update'); 
Route::delete('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.delete'); 

Route::get('/reports/delete', [\App\Http\Controllers\ReportController::class, 'delete']); 
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
