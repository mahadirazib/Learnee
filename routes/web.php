<?php

use App\Http\Controllers\Classroom\NoticeController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomControllerGlobal;
use App\Http\Controllers\ClassroomNoticeController;
use App\Http\Controllers\DepartmentChangeAdminController;
use App\Http\Controllers\DepartmentNoticeController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InstituteChangeAdminController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\InstituteControllerGlobal;
use App\Http\Controllers\InstituteDepartmentController;
use App\Http\Controllers\InstituteNoticeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PublicPostController;
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



Route::get('/dashboard', [HomePageController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



Route::resource('profile', UserProfileController::class);


// Global Routes.
Route::get('user/{user_id}', [UserController::class, 'index'])->middleware(['auth'])->name('user.view');
Route::get('institute/search', [InstituteControllerGlobal::class, 'index'])->middleware(['auth'])->name('global.institute.search');


// User Post related
Route::post('public/post/create', [PublicPostController::class, 'create'])->middleware(['auth'])->name('public.post.create');













// Institute and user related (Institute default page)
Route::get('institute', [InstituteController::class, 'index'])->middleware(['auth'])->name('institute');


// User and Classroom related. Classroom default page
Route::get('classroom/', [ClassroomControllerGlobal::class, 'index'])->middleware(['auth'])->name('classroom');
Route::get('classroom/search', [ClassroomControllerGlobal::class, 'search'])->middleware(['auth'])->name('classroom.search');



// Institute creat update delete
Route::get('institute/create_institute', [InstituteController::class, 'create'])->middleware(['auth', 'idtype.teacher'])->name('institute.create-form');
Route::post('institute/create', [InstituteController::class, 'store'])->middleware(['auth', 'idtype.teacher'])->name('institute.create');
Route::get('institute/edit/{institute_id}', [InstituteController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.edit-form');
Route::post('institute/update/{institute_id}', [InstituteController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.update');


// Single institute related
Route::get('institute/{institute_id}', [InstituteController::class, 'show_single'])->middleware(['auth'])->name('institute.view-single');
Route::get('institute/{institute_id}/join', [InstituteController::class, 'join'])->middleware(['auth'])->name('institute.join');
Route::post('institute/{institute_id}/join', [InstituteController::class, 'join_confirm'])->middleware(['auth'])->name('institute.join.confirm');

// Institute and Department Admin change, delete 
Route::get('institute/{institute_id}/admin_list', [InstituteChangeAdminController::class, 'institute_admin_list'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.admin.list');
Route::post('institute/{institute_id}/admin_update', [InstituteChangeAdminController::class, 'institute_admin_update'])->middleware(['auth', 'idtype.teacher', 'institute.ownerandhead'])->name('institute.admin.update');
Route::post('institute/{institute_id}/owner/change', [InstituteChangeAdminController::class, 'institute_owner_update'])->middleware(['auth', 'idtype.teacher', 'institute.ownerandhead'])->name('institute.owner.update');
Route::post('institute/{institute_id}/institute_head/change', [InstituteChangeAdminController::class, 'institute_head_update'])->middleware(['auth', 'idtype.teacher', 'institute.ownerandhead'])->name('institute.head.update');
Route::post('institute/{institute_id}/admin/{admin_id}/change_role', [InstituteChangeAdminController::class, 'institute_admin_change_role'])->middleware(['auth', 'idtype.teacher', 'institute.ownerandhead'])->name('institute.admin.change_role');
Route::delete('institute/{institute_id}/admin_delete/{admin_id}', [InstituteChangeAdminController::class, 'institute_admin_delete'])->middleware(['auth', 'idtype.teacher', 'institute.ownerandhead'])->name('institute.admin.delete');
// ---------------------------------------------------------
Route::get('institute/{institute_id}/department/{department_id}/admin_list', [DepartmentChangeAdminController::class, 'dept_admin_list'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin'])->name('institute.department.admin.list');
Route::post('institute/{institute_id}/department/{department_id}/admin_update', [DepartmentChangeAdminController::class, 'dept_admin_update'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.admin.update');
Route::post('institute/{institute_id}/department/{department_id}/creator/change', [DepartmentChangeAdminController::class, 'dept_creator_update'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.creator.update');
Route::post('institute/{institute_id}/department/{department_id}/dept_head/change', [DepartmentChangeAdminController::class, 'dept_head_update'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.head.update');
Route::delete('institute/{institute_id}/department/{department_id}/admin_delete', [DepartmentChangeAdminController::class, 'dept_admin_delete'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.admin.delete');


// Json responses faculty list 
Route::get('/users_list', [ InstituteController::class,'teacher_list_json'])->middleware(['auth', 'idtype.teacher'])->name('search-user');


// Institute Notices 
Route::get('institute/{institute_id}/notice', [InstituteNoticeController::class, 'index'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.notice.all');
Route::get('institute/{institute_id}/notice/create', [InstituteNoticeController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.create');
Route::post('institute/{institute_id}/notice/store', [InstituteNoticeController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.store');
Route::get('institute/{institute_id}/notice/{notice_id}', [InstituteNoticeController::class, 'view'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.notice.single');
Route::get('institute/{institute_id}/notice/{notice_id}/edit', [InstituteNoticeController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.edit-form');
Route::post('institute/{institute_id}/notice/{notice_id}/update', [InstituteNoticeController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.notice.update');
Route::delete('institute/{institute_id}/notice/{notice_id}/delete', [InstituteNoticeController::class, 'destroy'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.notice.delete');


// Json responses faculty list 
Route::get('/institute_teacher_list/{institute_id}', [ InstituteDepartmentController::class,'teacher_list_json'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('search-institute-teacher');


// Institute Departments related 
Route::get('institute/{institute_id}/department', [InstituteDepartmentController::class, 'index'])->middleware(['auth'])->name('institute.department.all');
Route::get('institute/{institute_id}/department/create', [InstituteDepartmentController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.admin'])->name('institute.department.create');
Route::post('institute/{institute_id}/department/store', [InstituteDepartmentController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.admin' ])->name('institute.department.store');
Route::get('institute/{institute_id}/department/{department_id}', [InstituteDepartmentController::class, 'view'])->middleware(['auth'])->name('institute.department.view-single');
Route::get('institute/{institute_id}/department/{department_id}/edit', [InstituteDepartmentController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin'])->name('institute.department.edit-form');
Route::post('institute/{institute_id}/department/{department_id}/update', [InstituteDepartmentController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin' ])->name('institute.department.update');
Route::get('institute/{institute_id}/department/{department_id}/join', [InstituteDepartmentController::class, 'join'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.department.join');
Route::post('institute/{institute_id}/department/{department_id}/join_confirn', [InstituteDepartmentController::class, 'join_confirm'])->middleware(['auth', 'institute.facultyandstudent'])->name('institute.department.join.confirm');


// Institute-Department Notices 
Route::get('institute/{institute_id}/department/{department_id}/notice', [DepartmentNoticeController::class, 'index'])->middleware(['auth', 'institute.department.facultyandstudent'])->name('institute.department.notice.all');
Route::get('institute/{institute_id}/department/{department_id}/notice/create', [DepartmentNoticeController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin' ])->name('institute.department.notice.create');
Route::post('institute/{institute_id}/department/{department_id}/notice/store', [DepartmentNoticeController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin' ])->name('institute.department.notice.store');
Route::get('institute/{institute_id}/department/{department_id}/notice/{notice_id}', [DepartmentNoticeController::class, 'view'])->middleware(['auth', 'institute.department.facultyandstudent'])->name('institute.department.notice.single');
Route::get('institute/{institute_id}/department/{department_id}/notice/{notice_id}/edit', [DepartmentNoticeController::class, 'edit'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin' ])->name('institute.department.notice.edit-form');
Route::post('institute/{institute_id}/department/{department_id}/notice/{notice_id}/update', [DepartmentNoticeController::class, 'update'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin' ])->name('institute.department.notice.update');
Route::delete('institute/{institute_id}/department/{department_id}/notice/{notice_id}/delete', [DepartmentNoticeController::class, 'destroy'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin'])->name('institute.department.notice.delete');



// Classrooms inside institutes
Route::get('institute/{institute_id}/department/{department_id}/classroom/create', [ClassroomController::class, 'create'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin'])->name('institute.department.classroom.create');
Route::post('institute/{institute_id}/department/{department_id}/classroom/create', [ClassroomController::class, 'store'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin'])->name('institute.department.classroom.store');
Route::get('institute/{institute_id}/department/{department_id}/classroom/list', [ClassroomController::class, 'list'])->middleware(['auth', 'institute.department.facultyandstudent'])->name('institute.department.classroom.list');
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/view', [ClassroomController::class, 'view'])->middleware(['auth', 'institute.department.facultyandstudent'])->name('institute.department.classroom.view');
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/join', [ClassroomController::class, 'join'])->middleware(['auth', 'institute.department.facultyandstudent'])->name('institute.department.classroom.join');
Route::post('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/join_confirm', [ClassroomController::class, 'join_confirm'])->middleware(['auth', 'institute.department.facultyandstudent'])->name('institute.department.classroom.join.confirm');

// Json responses faculty list 
Route::get('department_teacher_list/{institute_id}/{department_id}', [ ClassroomController::class,'teacher_list_json'])->middleware(['auth', 'idtype.teacher', 'institute.department.admin' ])->name('search-department-teacher');


// Classroom View Dashboard
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/dashboard', [ ClassroomController::class, 'dashboard' ])->middleware(['auth', 'institute.department.class.facultyandstudent'])->name('classroom.dashboard');

// Classroom Resources


// Classroom Notice
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice', [ ClassroomNoticeController::class, 'list' ])->middleware(['auth', 'institute.department.class.facultyandstudent'])->name('institute.department.classroom.notice.list');
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice/create', [ ClassroomNoticeController::class, 'create' ])->middleware(['auth', 'institute.department.class.admin'])->name('institute.department.classroom.notice.create');
Route::post('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice/store', [ ClassroomNoticeController::class, 'store' ])->middleware(['auth', 'institute.department.class.admin'])->name('institute.department.classroom.notice.store');
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice/view/{notice_id}', [ ClassroomNoticeController::class, 'view' ])->middleware(['auth', 'institute.department.class.facultyandstudent'])->name('institute.department.classroom.notice.view');
Route::get('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice/edit/{notice_id}', [ ClassroomNoticeController::class, 'edit' ])->middleware(['auth', 'institute.department.class.admin'])->name('institute.department.classroom.notice.edit');
Route::post('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice/update/{notice_id}', [ ClassroomNoticeController::class, 'update' ])->middleware(['auth', 'institute.department.class.admin'])->name('institute.department.classroom.notice.update');
Route::delete('institute/{institute_id}/department/{department_id}/classroom/{classroom_id}/notice/delete/{notice_id}', [ ClassroomNoticeController::class, 'delete' ])->middleware(['auth', 'institute.department.class.admin'])->name('institute.department.classroom.notice.delete');








// For all institute 
// Route::get('institute/search', [InstituteController::class, 'search'])->middleware(['auth'])->name('institute.search');








// Route for test purpose
// Route::get('test/{institute_id}', [TestController::class, 'test'])->middleware(['auth', 'institute.facultyandstudent'])->name('test-route');
Route::get('test', [TestController::class, 'test'])->middleware(['auth'])->name('test-route');





