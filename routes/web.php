<?php

use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\SocialAccountsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Filepond\FilepondUploaderController;
use App\Http\Controllers\Place\MyPlacesController;
use App\Http\Controllers\Place\PlaceController;
use App\Http\Controllers\Place\PlaceLocationController;
use App\Http\Controllers\Place\PlaceLogoController;
use App\Http\Controllers\Place\PlacePhotosController;
use App\Http\Controllers\Review\ReviewController;
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

// 
// Routes to edit place's location
// 
Route::get('/places/{place}/location/edit', [PlaceLocationController::class, 'edit'])->name('places.location.edit');
Route::patch('/places/{place}/location', [PlaceLocationController::class, 'update'])->name('places.location.update');

Route::get('/places/{place}/logo/edit', [PlaceLogoController::class, 'edit'])->name('places.logo.edit');
Route::patch('/places/{place}/logo', [PlaceLogoController::class, 'update'])->name('places.logo.update');

Route::post('/api/places/{place}/photos', [PlacePhotosController::class, 'store'])->name('places.photos.store');
Route::patch('/api/places/{place}/photos', [PlacePhotosController::class, 'update'])->name('places.photos.update');
Route::get('/places/{place}/photos/edit', [PlacePhotosController::class, 'edit'])->name('places.photos.edit');

Route::resource('places.reviews', ReviewController::class)
	->except(['show']);

// 
// Routes for account settings
// 
Route::get('/account', fn () => redirect()->action([AccountProfileController::class, 'index']))->name('account.index');

Route::get('/account/profile', [AccountProfileController::class, 'index'])->name('account.profile');
Route::patch('/account/profile', [AccountProfileController::class, 'update'])->name('account.profile.update');

Route::get('/account/socialaccounts', [SocialAccountsController::class, 'index'])->name('account.social_accounts');
Route::delete('/account/socialaccounts/{oauthProvider}', [SocialAccountsController::class, 'destroy'])->name('account.social_accounts.destroy');

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

	Route::group([], function () {
		Route::get('/{provider}/redirect', [SocialiteLoginController::class, 'redirectToProvider'])->name('redirect');
		Route::get('/{provider}/callback', [SocialiteLoginController::class, 'handleProviderCallback'])->name('callback');
	})
		->middleware('guest');
});
