<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('user-password', function () {
    return view('user.user-password');
});

Auth::routes();

Route::post('Signupp', [UserController::class, 'Signupp'])->name('Signupp');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){
    //Admin
    Route::get('master-data', [AdminController::class, 'masterData'])->name('master-data');
    Route::post('change-password-admin', [AdminController::class, 'changePasswordAdmin'])->name('change-password-admin');
    Route::post('change-status-admin', [AdminController::class, 'changeStatusAdmin'])->name('change-status-admin');
    Route::post('add-department', [AdminController::class, 'addDepartment'])->name('add-department');
    Route::post('add-designation', [AdminController::class, 'addDesignation'])->name('add-designation');
    Route::get('update-department/{value}/{id}', [AdminController::class, 'updateDepartment'])->name('update-department');
    Route::get('update-designation/{value}/{id}', [AdminController::class, 'updateDesignation'])->name('update-designation');
    //User
    Route::get('create', [UserController::class, 'User'])->name('create');
    Route::post('user-create', [UserController::class, 'Create'])->name('user-create');
    Route::get('manage-user', [UserController::class, 'Display'])->name('manage-user');
    Route::get('profile', [UserController::class, 'userProfile'])->name('profile');
    Route::get('user-edit', [UserController::class, 'userEdit'])->name('user-edit');
    Route::post('edit-user', [UserController::class, 'Edituser'])->name('edit-user'); 
    Route::post('update-profile', [UserController::class, 'UpdateProfile'])->name('update-profile');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('change-password');
    //Complaint
    Route::get('new-complaint', [ComplaintController::class, 'Create'])->name('new-complaint');
    Route::get('manage-complaints', [ComplaintController::class, 'manageComplaints'])->name('manage-complaints');
    Route::get('complaints-view', [ComplaintController::class, 'Display'])->name('complaints-view');
    Route::get('master-settings', [ComplaintController::class, 'masterSetting'])->name('master-settings');
    Route::post('add-category', [ComplaintController::class, 'addCategory'])->name('add-category');
    Route::post('add-sub-category', [ComplaintController::class, 'addSubCategory'])->name('add-sub-category');
    Route::post('submit-complaint', [ComplaintController::class, 'submitComplaint'])->name('submit-complaint');
    Route::get('manage-complaints-user', [ComplaintController::class, 'manageUsersComplaint'])->name('manage-complaints-user');
    Route::get('complaints-view-user', [ComplaintController::class, 'DisplayUser'])->name('complaints-view-user');
    Route::get('chat/{complaint}/{userid}', [ComplaintController::class, 'Chat']);
    Route::post('chats', [ComplaintController::class, 'Chats']);
    Route::get('chat1/{complaint}/{userid}', [ComplaintController::class, 'Chat1']);
    Route::post('chats1', [ComplaintController::class, 'Chats1']);
    Route::get('read_at/{id}', [ComplaintController::class, 'Read'])->name('read_at');
    Route::get('count', [ComplaintController::class, 'countComplain'])->name('count');
    Route::get('category/{id}', [ComplaintController::class, 'Category'])->name('category');
    Route::post('support', [ComplaintController::class, 'Support'])->name('support');
    Route::get('completeComplaint/{id}', [ComplaintController::class, 'Complete']);
    //Role
    Route::get('role-create', [RoleController::class, 'roleCreate'])->name('role-create');
    Route::get('role-manage-new', [RoleController::class, 'roleManage'])->name('role-manage-new');
    Route::get('role-manage-neww', [RoleController::class, 'roleManagew'])->name('role-manage-neww');
    Route::post('roles-create', [RoleController::class, 'createRole'])->name('roles-create');
    Route::post('roles-manage-ajax', [RoleController::class, 'roleManageAjax'])->name('roles-manage-ajax');
    Route::get('ajax/{id}', [RoleController::class, 'ajax'])->name('ajax');
});
