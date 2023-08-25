<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
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
})->name('index');

Route::resource('places', PlaceController::class);

Route::resource('places.reviews', ReviewController::class);

// Socialite Authentcation
Route::name('auth.')->prefix('/auth')->group(function () {
	Route::view('/login', 'auth.login')
		->middleware('guest')
		->name('login');

	Route::delete('/logout', function () {
		Auth::logout();
		return redirect()->route('index');
	})
		->middleware('auth')
		->name('logout');

	Route::name('google.')->prefix('/google')->group(function () {
		Route::get('/redirect', [GoogleLoginController::class, 'redirectToProvider'])->name('redirect');
		Route::get('/callback', [GoogleLoginController::class, 'handleProviderCallback'])->name('callback');
	})
		->middleware('guest');
});
