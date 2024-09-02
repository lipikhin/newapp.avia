<?php


use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\WorkOrderController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->middleware(['auth'])->group(function (){


//    Route::redirect('/user','/user/work_orders')->name('user');
//
//
//    Route::get('work_orders',[WorkOrderController::class,
//        'index'])->name('user.work_orders.index');
//
//    Route::get('work_orders/create',[WorkOrderController::class,
//        'create'])->name('user.work_orders.create');
//
//    Route::post('work_orders/store',[WorkOrderController::class,
//        'store'])->name('user.work_orders.store');
//
//    Route::get('work_orders/{work_order}',
//        [WorkOrderController::class,'show'])->name('user.work_orders.show');
//
//    Route::get('work_orders/{work_orders}/edit',
//        [WorkOrderController::class,'edit'])->name('user.work_orders.edit');
//
//    Route::put('work_orders/{work_order}',
//        [WorkOrderController::class,'update'])->name('user.work_orders.update');
//
//    Route::delete('work_orders/{work_order}',
//        [WorkOrderController::class, 'destroy'])->name('user.work_orders.destroy');



    Route::get('profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('profile/create', [ProfileController::class, 'create'])->name('user.profile.create');
    Route::post('profile', [ProfileController::class, 'store'])->name('user.profile.store');
    Route::get('profile/{profile}', [ProfileController::class, 'show'])->name('user.profile.show');
    Route::get('profile/{profile}/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('profile/{profile}', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('profile/{profile}', [ProfileController::class, 'destroy'])->name('user.profile.destroy');




});


