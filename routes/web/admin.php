<?php
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\RulesController;
use App\Http\Controllers\Admin\User\UserPermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    auth()->loginUsingId(1);
    return view('admin.index');
});

Route::resource('users', UserController::class);
        Route::get('/users/{user}/permissions', [UserPermissionController::class, 'create'])->name('users.permissions')->middleware('can:staff-users-permission');
        Route::post('/users/{user}/permissions', [UserPermissionController::class, 'store'])->name('users.permissions.store')->middleware('can:staff-users-permission');


Route::resource('permissions', PermissionController::class);
Route::resource('rules', RulesController::class);


// products
Route::resource('products', ProductController::class)->except(['show']);

// products gallery
Route::resource('products.gallery', ProductGalleryController::class)->except(['show']);

// comments
Route::get('comments/unapproved', [CommentController::class, 'unapproved'])->name('comments.unapproved');
Route::resource('comments', CommentController::class)->only(['index', 'update', 'destroy', 'unapproved']);


// category
Route::resource('categories', CategoryController::class);
