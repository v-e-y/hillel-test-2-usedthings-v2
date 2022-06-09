<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Oauth\FacebookController;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Auth
 */
Route::controller(AuthController::class)
    ->name('auth.')
    ->group(function() {
        Route::post('/signin', 'signIn')
            ->middleware('guest')
            ->name('signIn');

        Route::get('/logout', function() {
            Session::flush();
            Auth::logout();
            return redirect()->route('ad.index');
        })
        ->middleware('auth')
        ->name('logOut');
    });

/**
 * Oauth
 */
Route::get('/facebook/oauth', [FacebookController::class, 'oauth'])
    ->middleware('guest');

/**
 * Advertisement
 */
Route::controller(AdvertisementController::class)
    ->name('ad.')
    ->group(function() {
        Route::get('/', 'index')->name('index');

        Route::get('/delete/{advertisement}', 'delete')
            ->middleware([
                'auth',
                'can:delete,advertisement'
            ])
            ->name('delete');

        Route::get('/edit', 'create')
            ->middleware('auth')
            ->name('create');

        Route::get('/edit/{advertisement}', 'edit')
            ->middleware([
                'auth',
                'can:update,advertisement'
            ])
            ->name('edit');

        Route::patch('/edit/{advertisement}/update', 'update')
            ->middleware([
                'auth',
                'can:update,advertisement'
            ])
            ->name('update');

        Route::post('/edit/store', 'store')
            ->middleware('auth')
            ->name('store');

        Route::get('/{id}', 'show')->name('show');
    });
