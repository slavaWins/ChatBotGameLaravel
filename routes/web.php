<?php

use Illuminate\Support\Facades\Route;
use SlavaWins\AuthSms\Library\AuthSmsRoute;
use SlavaWins\AdminWinda\Library\AdminWindaRoute;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


AuthSmsRoute::routes();
AdminWindaRoute::routes();

Route::any('/cron/scene-timer', [\App\Http\Controllers\Bot\BotLogicController::class, 'SceneTimerCronAction'])->name("bot.cron");

Route::group(['middleware' => ['auth']], function () {


    Route::get('/messagebox', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'index'])->name('messagebox.index');
    Route::get('/messagebox/action/clear-history', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'ClearHistory'])->name('messagebox.action.clearmessage');
    Route::get('/messagebox/action/autotest', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'AutoTest'])->name('messagebox.action.autotest');
    Route::get('/messagebox/action/resetuser', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'Resetuser'])->name('messagebox.action.resetuser');
    Route::any('/api/messagebox/send', [\App\Http\Controllers\Bot\Dev\MessageBoxController::class, 'SendMessage']);


    Route::get('/admin/bot/virutal/room/{className}/new/step', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'createStep'])->name('bot.virtual.room.new.step');
    Route::post('/admin/bot/virutal/new/room', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'createRoom'])->name('bot.virtual.room.new.room');
    Route::get('/admin/bot/virutal/room/{className}/edit', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'index'])->name('bot.virtual.room');
    Route::get('/admin/bot/virutal/room/{className}/play', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'play'])->name('bot.virtual.room.play');
    Route::post('/admin/bot/virutal/update/step/{vs}', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'store'])->name('bot.virtual.room.save');
    Route::post('/admin/bot/virutal/update/room/{vs}', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'updateRoom'])->name('bot.virtual.room.save.room');

    Route::get('/admin/bot/virutal/character/{className}', [\App\Http\Controllers\Bot\Virtual\RoomVirtualController::class, 'character'])->name('bot.virtual.character');


    Route::get('/admin/excel', [\App\Http\Controllers\LikeExcel\LikeExcelController::class, 'index'])->name('admin.excel');

    Route::get('/admin', [\App\Http\Controllers\AdminPageController::class, 'index'])->name('admin');


    Route::get('/admin/users/history/{userShow}', [\App\Http\Controllers\Bot\Admin\Users\UsersAdminController::class, 'history'])->name('admin.user.history');
    Route::get('/admin/character/show/{character}', [\App\Http\Controllers\Bot\Admin\Character\CharacterAdminController::class, 'show'])->name('admin.character.show');
    Route::post('/admin/character/edit/{character}', [\App\Http\Controllers\Bot\Admin\Character\CharacterAdminController::class, 'update'])->name('admin.character.edit');

    Route::get('/admin/itemshop/cat', [\App\Http\Controllers\Bot\Admin\Bot\ItemCharacterShopAdminController::class, 'categorys'])->name('admin.itemshop.cat');
    Route::get('/admin/itemshop/cat/{catClassName}', [\App\Http\Controllers\Bot\Admin\Bot\ItemCharacterShopAdminController::class, 'showCategory'])->name('admin.itemshop.showCategory');
    Route::get('/admin/itemshop/cat/{catClassName}/create', [\App\Http\Controllers\Bot\Admin\Bot\ItemCharacterShopAdminController::class, 'create'])->name('admin.itemshop.showCategory.create');
    Route::post('/admin/itemshop/edit/cat/{catClassName}/to/{id}', [\App\Http\Controllers\Bot\Admin\Bot\ItemCharacterShopAdminController::class, 'editSave'])->name('admin.itemshop.edit');

    /*
     *
     *
    Route::get('/admin/orders/list', [App\Http\Controllers\AdminWinda\AdminPageController::class, 'OrderList'])->name('admin.order.list');
    Route::get('/admin/orders/edit/{order}', [App\Http\Controllers\AdminWinda\AdminPageController::class, 'OrderDeteils'])->name('admin.order.edit');
    Route::post('/admin/orders/edit/{order}', [App\Http\Controllers\AdminWinda\AdminPageController::class, 'OrderEditSave'])->name('admin.order.edit.save');
    Route::post('/admin/orders/statusedit/{order}', [App\Http\Controllers\AdminWinda\AdminPageController::class, 'OrderEditStatus'])->name('admin.order.edit.status');
*/


    Route::get('/profile', [App\Http\Controllers\UserProfile::class, 'index'])->name('profile');
    Route::post('/profile-update', [App\Http\Controllers\UserProfile::class, 'RequestUpdate'])->name('profile-update');

    Route::get('/id{user}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');


});
