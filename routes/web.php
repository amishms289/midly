<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\SocialLoginController;

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

Route::get('social-auth/{provider}/callback',[SocialLoginController::class,'providerCallback']);
Route::get('social-auth/{provider}',[SocialLoginController::class,'redirectToProvider'])->name('social.redirect');

Auth::routes([
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile/{user}', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/sync-listning/{user}', [UserController::class, 'syncListning'])->name('user.sync-listning');
    Route::get('/user/view-listning/{user}', [UserController::class, 'viewListning'])->name('user.view-listning');
});
