<?php

use Illuminate\Support\Facades\Route;
use SlavaWins\AuthSms\Library\AuthSmsRoute;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


AuthSmsRoute::routes();


Route::group(['middleware' => ['auth']], function () {


    Route::get('/messagebox', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'index'])->name('messagebox.index');
    Route::get('/messagebox/action/clear-history', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'ClearHistory'])->name('messagebox.action.clearmessage');
    Route::get('/messagebox/action/autotest', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'AutoTest'])->name('messagebox.action.autotest');
    Route::get('/messagebox/action/resetuser', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'Resetuser'])->name('messagebox.action.resetuser');
    Route::any('/api/messagebox/send', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'SendMessage']);


    Route::get('/admin', [App\Http\Controllers\Admin\AdminPageController::class, 'index'])->name('admin');


    Route::get('/admin/users/list', [App\Http\Controllers\Admin\Users\UsersAdminController::class, 'index'])->name('admin.user.list');
    Route::get('/admin/users/show/{userShow}', [App\Http\Controllers\Admin\Users\UsersAdminController::class, 'show'])->name('admin.user.show');
    Route::get('/admin/users/history/{userShow}', [App\Http\Controllers\Admin\Users\UsersAdminController::class, 'history'])->name('admin.user.history');
    Route::get('/admin/character/show/{character}', [App\Http\Controllers\Admin\Character\CharacterAdminController::class, 'show'])->name('admin.character.show');
    Route::post('/admin/character/edit/{character}', [App\Http\Controllers\Admin\Character\CharacterAdminController::class, 'update'])->name('admin.character.edit');

    Route::get('/admin/itemshop/cat', [App\Http\Controllers\Admin\Bot\ItemCharacterShopAdminController::class, 'categorys'])->name('admin.itemshop.cat');
    Route::get('/admin/itemshop/cat/{catClassName}', [App\Http\Controllers\Admin\Bot\ItemCharacterShopAdminController::class, 'showCategory'])->name('admin.itemshop.showCategory');
    Route::get('/admin/itemshop/cat/{catClassName}/create', [App\Http\Controllers\Admin\Bot\ItemCharacterShopAdminController::class, 'create'])->name('admin.itemshop.showCategory.create');
    Route::post('/admin/itemshop/edit/cat/{catClassName}/to/{id}', [App\Http\Controllers\Admin\Bot\ItemCharacterShopAdminController::class, 'editSave'])->name('admin.itemshop.edit');

    /*
    Route::get('/admin/orders/list', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderList'])->name('admin.order.list');
    Route::get('/admin/orders/edit/{order}', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderDeteils'])->name('admin.order.edit');
    Route::post('/admin/orders/edit/{order}', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderEditSave'])->name('admin.order.edit.save');
    Route::post('/admin/orders/statusedit/{order}', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderEditStatus'])->name('admin.order.edit.status');
*/


    Route::get('/profile', [App\Http\Controllers\UserProfile::class, 'index'])->name('profile');
    Route::post('/profile-update', [App\Http\Controllers\UserProfile::class, 'RequestUpdate'])->name('profile-update');

    Route::get('/id{user}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');


});
