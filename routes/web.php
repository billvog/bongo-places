<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\FilepondUploaderController;
use App\Http\Controllers\MyPlacesController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlacePhotosController;
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

Route::post('/filepond', [FilepondUploaderController::class, 'process'])->name('filepond-server');
Route::delete('/filepond', [FilepondUploaderController::class, 'revert'])->name('filepond-server');

Route::get('/my/places', [MyPlacesController::class, 'index'])->name('my-places.index');

Route::resource('places', PlaceController::class);

Route::resource('places.photos', PlacePhotosController::class)->only('create', 'store');
Route::patch('/api/places/{place}/photos', [PlacePhotosController::class, 'update'])->name('places.photos.update');
Route::get('/places/{place}/photos/edit', [PlacePhotosController::class, 'edit'])->name('places.photos.edit');

Route::resource('places.reviews', ReviewController::class)
	->except(['show']);

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
