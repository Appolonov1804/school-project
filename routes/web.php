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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('admin.restrictions')->group(function () {
Route::get('/teachers/create', [\App\Http\Controllers\MainController::class, 'create'])->name('teachers.create'); 
Route::post('/teachers', [\App\Http\Controllers\MainController::class, 'store'])->name('teachers.store');
Route::get('/teachers/{teacher}/edit', [\App\Http\Controllers\MainController::class, 'edit'])->name('teachers.edit');
Route::patch('/teachers/{teacher}', [\App\Http\Controllers\MainController::class, 'update'])->name('teachers.update');
Route::delete('/teachers/{teacher}', [\App\Http\Controllers\MainController::class, 'destroy'])->name('teachers.delete');
Route::post('/teachers/reset-salary/{teacher}', [\App\Http\Controllers\MainController::class, 'resetSalary'])->name('teachers.resetSalary');


Route::get('/teachers/update', [\App\Http\Controllers\MainController::class, 'update']); 

Route::get('/teachers/delete', [\App\Http\Controllers\MainController::class, 'delete']); 


Route::get('/rosters/create', [\App\Http\Controllers\RosterController::class, 'create'])->name('rosters.create');
Route::post('/rosters', [\App\Http\Controllers\RosterController::class, 'store'])->name('rosters.store');
Route::get('/rosters/{roster}', [\App\Http\Controllers\RosterController::class, 'show'])->name('rosters.show');
Route::get('/rosters/{roster}/edit', [\App\Http\Controllers\RosterController::class, 'edit'])->name('rosters.edit');
Route::patch('/rosters/{roster}', [\App\Http\Controllers\RosterController::class, 'update'])->name('rosters.update');
Route::delete('/rosters/{roster}', [\App\Http\Controllers\RosterController::class, 'destroy'])->name('rosters.delete');
Route::get('/rosters/delete', [\App\Http\Controllers\RosterController::class, 'delete']); 

Route::get('/groups/create', [\App\Http\Controllers\GroupController::class, 'create'])->name('groups.create');
Route::post('/groups', [\App\Http\Controllers\GroupController::class, 'store'])->name('groups.store');
Route::get('/groups/{group}/edit', [\App\Http\Controllers\GroupController::class, 'edit'])->name('groups.edit');
Route::patch('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'update'])->name('groups.update');
Route::delete('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'destroy'])->name('groups.delete');
Route::get('/groups/delete', [\App\Http\Controllers\GroupController::class, 'delete']); 
Route::get('/teachers/{teacher}/groups', [\App\Http\Controllers\GroupController::class, 'showGroup'])->name('groups.show');

Route::get('/rosters/{roster}/edit/{lesson_id}', [\App\Http\Controllers\LessonController::class, 'editLesson'])->name('lessons.edit');
Route::patch('/rosters/{roster}/update_lesson/{lesson_id}', [\App\Http\Controllers\LessonController::class, 'updateLesson'])->name('lessons.updateLesson');
Route::get('/rosters/{roster}/create', [\App\Http\Controllers\LessonController::class, 'create'])->name('lessons.create');
Route::post('/lessons', [\App\Http\Controllers\LessonController::class, 'store'])->name('lessons.store');
Route::delete('/rosters/{roster}/{lesson_id}', [\App\Http\Controllers\LessonController::class, 'destroy'])->name('lessons.delete');
Route::get('/lessons/delete', [\App\Http\Controllers\LessonController::class, 'delete']); 

Route::get('/group_lessons/{group}/{group_lesson_id}/edit', [\App\Http\Controllers\GroupLessonController::class, 'editLesson'])->name('groupsLessons.edit');
Route::patch('/group_lessons/{group}/update_group_lesson/{lesson}', [\App\Http\Controllers\GroupLessonController::class, 'updateLesson'])->name('groupLessons.updateLesson');
Route::get('/group_lessons/{group}/create', [\App\Http\Controllers\GroupLessonController::class, 'create'])->name('groupsLessons.create');
Route::post('/group_lessons/{group}', [\App\Http\Controllers\GroupLessonController::class, 'store'])->name('groupsLessons.store');
Route::delete('/group_lessons/{group}/{group_lesson_id}', [\App\Http\Controllers\GroupLessonController::class, 'destroy'])->name('groupsLessons.delete');
Route::get('/group_lessons/delete', [\App\Http\Controllers\GroupLessonController::class, 'delete']); 


Route::get('/reports/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create'); 
Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store'); 
Route::get('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'show'])->name('reports.show');
Route::get('/reports/{report}/edit', [\App\Http\Controllers\ReportController::class, 'edit'])->name('reports.edit'); 
Route::patch('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'update'])->name('reports.update'); 
Route::delete('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.delete'); 
Route::get('/reports/delete', [\App\Http\Controllers\ReportController::class, 'delete']); 
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/teachers/{teacher}', [\App\Http\Controllers\MainController::class, 'show'])->name('teachers.show');



Route::group(['namespace' => 'Controllers', 'prefix' => 'admin', 'middleware' => 'admin'], function() {
Route::group(['namespace' => 'Controllers'], function() {
    Route::get('/roster', [App\Http\Controllers\AdminRosterController::class, 'store'])->name('admin.roster.roster');
   });
});



Route::group(['namespace' => 'Controllers', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
Route::group(['namespace' => 'Controllers'], function() { 
    Route::get('/report', [App\Http\Controllers\AdminReportController::class, 'store'])->name('admin.report.report');
    });
});


Route::group(['namespace' => 'Controllers', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
Route::group(['namespace' => 'Controllers'], function() { 
    Route::get('/teacher', [App\Http\Controllers\AdminTeacherController::class, 'store'])->name('admin.teacher.teacher');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/teachers/{teacher}/reports', [\App\Http\Controllers\MainController::class, 'showTeachersReports'])->name('teachers.reportShow');

Route::post('/upload', [App\Http\Controllers\UploadController::class, 'store'])->name('upload.store');
Route::get('/upload', function () {
    return view('upload');
});

