<?php

use App\Helpers\Cart\Cart;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Payment;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthenticateTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Profile\IndexController;
use App\Http\Controllers\Profile\TokenAuthController;
use App\Http\Controllers\Profile\TwoFactorAuthController;
use App\Http\Controllers\ProfileController;
use App\Models\ActiveCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Morilog\Jalali\Jalalian;
use RealRashid\SweetAlert\Facades\Alert;

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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index']);

Auth::routes([
    'verify' => true
]);
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// auth token
Route::get('/auth/token', [AuthenticateTokenController::class, 'getToken'])->name('2fa.token');
Route::post('/auth/token', [AuthenticateTokenController::class, 'postToken']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/secret', function(){
    return 'secret';
})->middleware('auth', 'password.confirm');


// profile
Route::middleware('auth')->prefix('/profile')->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::get('/twofactor', [TwoFactorAuthController::class, 'manageTwoFactor'])->name('profile.2fa.manage');
    Route::post('/twofactor', [TwoFactorAuthController::class, 'postManageTwoFactor']);

    // phone verify
    Route::get('/twofactor/phone', [TokenAuthController::class, 'getPhoneVerify'])->name('profile.2fa.phone');
    Route::post('/twofactor/phone', [TokenAuthController::class, 'postPhoneVerify']);
});


// products
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'single']);

// comments
Route::post('comments', [HomeController::class, 'comment'])->middleware('auth')->name('send.comment');


// cart
// Route::get('cart', [CartController::class, 'cart']);
// Route::post('cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
// Route::patch('cart/quantity/change', [CartController::class, 'quantityChange']);
// Route::delete('cart/delete/{cart}', [CartController::class, 'deleteFromCart'])->name('cart.destroy');

// payment
Route::middleware('auth')->group( function () {
    Route::post('payment', [PaymentController::class, 'payment'])->name('cart.payment');

    Route::post('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    // some important points about payment =>
    /*
    1) payment method would be differenct from eachone via their company. forexample one uses Route::post other uses get method.
    2) if it is POST method, remeber to add the url to the exept of verifycsrftoken provider service. get method desnt need.
    */
});

// downloads
Route::get('download/{file}', function ($file) {
    return Storage::download('files/', $file);
});
Route::get('download/{user}/file', function ($file) {
    return Storage::download(request('path'));
})->name('download.file')->middleware('signed');

/*
        Route::get('download/{user}/file', function ($file) {
            return Storage::download(request('path'));
        })->name('download.file')->middleware('signed');

        return URL::temporarySignedRoute('download.file', now()->addMinutes(120), ['user' => auth()->user()->id, 'path' => '/files/mongodb.png']);

1) first create a download route which has 'signed' & 'auth' middlware in it like above. now for this signed url we need an exclusive url. to create that exclusive url =>
2) use URL::temporaysignedroute() that accepts 3 parameters.    1. route name   2. expiration time  3. auth user and path url infos

*/
