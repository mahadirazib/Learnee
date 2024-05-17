<?php

use App\Http\Controllers\InstituteController;
use App\Http\Controllers\InstituteControllerGlobal;
use App\Http\Controllers\InstituteDepartmentController;
use App\Http\Controllers\InstituteNoticeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



Route::resource('profile', UserProfileController::class);


// Global institute related.
Route::get('institute/search', [InstituteControllerGlobal::class, 'index'])->middleware(['auth'])->name('global.institute.search');


// Institute and user related (Institute default page)
Route::get('institute', [InstituteController::class, 'index'])->middleware(['auth'])->name('institute');


// Institute creat update delete
Route::get('institute/create_institute', [InstituteController::class, 'create'])->middleware(['auth', 'idtype.teacher'])->name('institute.create-form');
Route::post('institute/create', [InstituteController::class, 'store'])->middleware(['auth', 'idtype.teacher'])->name('institute.create');
Route::get('institute/edit/{institute_id}', [InstituteController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.edit-form');
Route::post('institute/update/{institute_id}', [InstituteController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.update');


// Single institute related
Route::get('institute/{institute_id}', [InstituteController::class, 'show_single'])->middleware(['auth'])->name('institute.view-single');
Route::get('institute/{institute_id}/join', [InstituteController::class, 'join'])->middleware(['auth'])->name('institute.join');
Route::post('institute/{institute_id}/join', [InstituteController::class, 'join_confirm'])->middleware(['auth'])->name('institute.join.confirm');


// Institute Notices 
Route::get('institute/{institute_id}/notice', [InstituteNoticeController::class, 'index'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.notice.all');
Route::get('institute/{institute_id}/notice/create', [InstituteNoticeController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.create');
Route::post('institute/{institute_id}/notice/store', [InstituteNoticeController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.store');
Route::get('institute/{institute_id}/notice/{notice_id}/edit', [InstituteNoticeController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.edit-form');
Route::post('institute/{institute_id}/notice/{notice_id}/update', [InstituteNoticeController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.update');
Route::get('institute/{institute_id}/notice/{notice_id}', [InstituteNoticeController::class, 'view'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.notice.single');
Route::delete('institute/{institute_id}/notice/{notice_id}/delete', [InstituteNoticeController::class, 'destroy'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.notice.delete');

// Json responses faculty list 
Route::get('/users_list', [ InstituteController::class,'teacher_list_json'])->middleware(['auth', 'idtype.teacher'])->name('search-user');
Route::get('/institute_teacher_list/{institute_id}', [ InstituteDepartmentController::class,'teacher_list_json'])->middleware(['auth', 'idtype.teacher'])->name('search-institute-teacher');


// Institute Departments related 
Route::get('institute/{institute_id}/department', [InstituteDepartmentController::class, 'index'])->middleware(['auth'])->name('institute.department.all');
Route::get('institute/{institute_id}/department/create', [InstituteDepartmentController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.create');
Route::post('institute/{institute_id}/department/store', [InstituteDepartmentController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.department.store');
Route::get('institute/{institute_id}/department/{department_id}', [InstituteDepartmentController::class, 'view'])->middleware(['auth'])->name('institute.department.view-single');


// Institute Notices 
Route::get('institute/{institute_id}/department/{department_id}/notice', [InstituteNoticeController::class, 'index'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.department.notice.all');
Route::get('institute/{institute_id}/department/{department_id}/notice/create', [InstituteNoticeController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.department.notice.create');
Route::post('institute/{institute_id}/department/{department_id}/notice/store', [InstituteNoticeController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.department.notice.store');
Route::get('institute/{institute_id}/department/{department_id}/notice/{notice_id}/edit', [InstituteNoticeController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.department.notice.edit-form');
Route::post('institute/{institute_id}/department/{department_id}/notice/{notice_id}/update', [InstituteNoticeController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.department.notice.update');
Route::get('institute/{institute_id}/department/{department_id}/notice/{notice_id}', [InstituteNoticeController::class, 'view'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.department.notice.single');
Route::delete('institute/{institute_id}/department/{department_id}/notice/{notice_id}/delete', [InstituteNoticeController::class, 'destroy'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.notice.delete');





// For all institute 
// Route::get('institute/search', [InstituteController::class, 'search'])->middleware(['auth'])->name('institute.search');








// Route for test purpose
// Route::get('test/{institute_id}', [TestController::class, 'test'])->middleware(['auth', 'institute.facultyandstudent'])->name('test-route');
Route::get('test', [TestController::class, 'test'])->middleware(['auth'])->name('test-route');





