<?php

use App\Http\Controllers\Admin\AirCraftController;
use App\Http\Controllers\Admin\CmmController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MFRController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ScopeController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Admin\UnitController;
//use App\Http\Controllers\Admin\WorkOrderController;

Route::prefix('admin')->middleware(['auth'])->group(function (){

//    Route::redirect('/admin','/admin/work_orders')->name('admin');
//
//    Route::get('work_orders',[WorkOrderController::class,
//        'index'])->name('admin.work_orders');
//
//    Route::get('work_orders/create',[WorkOrderController::class,
//        'create'])->name('admin.work_orders.create');
//
//    Route::post('work_orders',[WorkOrderController::class,
//        'store'])->name('admin.work_orders.store');
//
//    Route::get('work_orders/{work_order}',
//        [WorkOrderController::class,'show'])->name('admin.work_orders.show');
//
//    Route::get('work_orders/{work_orders}/edit',
//        [WorkOrderController::class,'edit'])->name('admin.work_orders.edit');
//
//    Route::put('work_orders/{work_order}',
//        [WorkOrderController::class,'update'])->name('admin.work_orders.update');
//
//    Route::delete('work_orders/{work_order}',
//        [WorkOrderController::class, 'destroy'])->name('admin.work_orders.destroy');


    Route::get('customers',[CustomerController::class,
        'index'])->name('admin.customers.index');
    Route::get('customers/create',[CustomerController::class,
        'create'])->name('admin.customers.create');
    Route::post('customers',[CustomerController::class,
        'store'])->name('admin.customers.store');
    Route::get('customers/{customer}',[CustomerController::class,
        'show'])->name('admin.customers.show');
    Route::get('customers/{customer}/edit',[CustomerController::class,
        'edit'])->name('admin.customers.edit');
    Route::put('customers/{customer}',[CustomerController::class,
        'update'])->name('admin.customers.update');
    Route::delete('customers/{customer}',[CustomerController::class,
        'destroy'])->name('admin.customers.destroy');

    Route::get('cmms',[CmmController::class, 'index'])->name('admin.cmms.index');
    Route::get('cmms/create',[CmmController::class, 'create'])->name('admin.cmms.create');
    Route::post('cmms',[CmmController::class,
        'store'])->name('admin.cmms.store');
    Route::get('cmms/{cmms}',[CmmController::class,
        'show'])->name('admin.cmms.show');
    Route::get('cmms/{cmms}/edit',[CmmController::class,
        'edit'])->name('admin.cmms.edit');
    Route::put('cmms/{cmms}',[CmmController::class,
        'update'])->name('admin.cmms.update');
    Route::delete('cmms/{cmms}',[CmmController::class,
        'destroy'])->name('admin.cmms.destroy');

    Route::post('/aircrafts/store',[AirCraftController::class,
        'store'])->name('admin.aircrafts.store');
    Route::post('/mfrs/store',
        [MFRController::class,'store'])->name('admin.mfrs.store');
    Route::post('/scopes/store',
        [ScopeController::class,'store'])->name('admin.scopes.store');

//    Route::get('units',[UnitController::class, 'index'])->name('admin.units.index');
//    Route::get('units/create',
//        [UnitController::class,'create'])->name('admin.units.create');
//    Route::post('units',[UnitController::class,'store'])->name('admin.units.store');
//    Route::get('units/{unit}',[UnitController::class,
//        'show'])->name('admin.units.show');
//    Route::get('units/{unit}/edit',[UnitController::class,
//        'edit'])->name('admin.units.edit');
//    Route::put('units/{unit}',[UnitController::class,
//        'update'])->name('admin.units.update');
//    Route::delete('units/{unit}',[UnitController::class,
//        'destroy'])->name('admin.units.destroy');

    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('/users',[UsersController::class,'store'])->name('admin.users.store');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('admin.users.update');

    Route::get('/users/{users}/edit', [UsersController::class, 'edit'])->name
    ('admin.users.edit');

    Route::delete('/users/{users}', [UsersController::class, 'destroy'])->name
    ('admin.users.destroy');




    Route::post('/roles/store', [RoleController::class, 'store'])->name('admin.roles.store');

    Route::post('/teams/store', [TeamController::class, 'store'])->name('admin.teams.store');

// М

});
