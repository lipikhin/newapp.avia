<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "clean Ok";
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=> true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

Route::post('/admin/users/{user}/update-role', [UsersController::class, 'updateRole']);
Route::post('/admin/users/{user}/update-team', [UsersController::class, 'updateTeam']);

//    Route::post('/admin/roles', [RoleController::class, 'store'])->name('roles.store');
//    Route::post('/admin/teams', [TeamController::class, 'store'])->name('teams.store');
//Route::post('/users/avatars-update', [UsersController::class, 'updateAvatar'])
//    ->name('users.avatars.update');


