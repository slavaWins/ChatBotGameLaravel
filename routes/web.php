<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\Bot\Admin\Bot\ItemCharacterShopAdminController;
use App\Http\Controllers\Bot\Admin\Character\CharacterAdminController;
use App\Http\Controllers\Bot\BotLogicController;
use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Http\Controllers\Bot\Virtual\RoomVirtualController;
use App\Http\Controllers\LikeExcel\LikeExcelController;
use App\Http\Controllers\PropertyBuilder\ExampleController;
use Illuminate\Support\Facades\Route;
use SlavaWins\AuthSms\Library\AuthSmsRoute;
use SlavaWins\AdminWinda\Library\AdminWindaRoute;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


AuthSmsRoute::routes();


Route::any('/cron/scene-timer', [BotLogicController::class, 'SceneTimerCronAction'])->name("bot.cron");

Route::group(['middleware' => ['auth']], function () {

    AdminWindaRoute::routes();

    Route::get('/property-builder', [ExampleController::class, 'index'])->name('property-builder.index');
    Route::post('/property-builder', [ExampleController::class, 'story'])->name('property-builder.story');

    Route::get('/messagebox', [MessageBoxController::class, 'index'])->name('messagebox.index');
    Route::get('/messagebox/action/clear-history', [MessageBoxController::class, 'ClearHistory'])->name('messagebox.action.clearmessage');
    Route::get('/messagebox/action/autotest', [MessageBoxController::class, 'AutoTest'])->name('messagebox.action.autotest');
    Route::get('/messagebox/action/resetuser', [MessageBoxController::class, 'Resetuser'])->name('messagebox.action.resetuser');
    Route::any('/api/messagebox/send', [MessageBoxController::class, 'SendMessage']);


    Route::get('/admin/bot/virutal/room/{className}/new/step', [RoomVirtualController::class, 'createStep'])->name('bot.virtual.room.new.step');
    Route::post('/admin/bot/virutal/new/room', [RoomVirtualController::class, 'createRoom'])->name('bot.virtual.room.new.room');
    Route::get('/admin/bot/virutal/room/{className}/edit', [RoomVirtualController::class, 'index'])->name('bot.virtual.room');
    Route::get('/admin/bot/virutal/room/{className}/play', [RoomVirtualController::class, 'play'])->name('bot.virtual.room.play');
    Route::post('/admin/bot/virutal/update/step/{vs}', [RoomVirtualController::class, 'store'])->name('bot.virtual.room.save');
    Route::post('/admin/bot/virutal/update/room/{vs}', [RoomVirtualController::class, 'updateRoom'])->name('bot.virtual.room.save.room');

    Route::get('/admin/bot/virutal/character/{className}', [RoomVirtualController::class, 'character'])->name('bot.virtual.character');


    Route::get('/admin/excel', [LikeExcelController::class, 'index'])->name('admin.excel');

    Route::get('/admin', [AdminPageController::class, 'index'])->name('admin');


    Route::get('/admin/users/history/{userShow}', [\App\Http\Controllers\Bot\Admin\Users\UsersAdminController::class, 'history'])->name('admin.user.history');
    Route::get('/admin/character/show/{character}', [CharacterAdminController::class, 'show'])->name('admin.character.show');
    Route::post('/admin/character/edit/{character}', [CharacterAdminController::class, 'update'])->name('admin.character.edit');

    Route::get('/admin/itemshop/cat', [ItemCharacterShopAdminController::class, 'categorys'])->name('admin.itemshop.cat');
    Route::get('/admin/itemshop/cat/{catClassName}', [ItemCharacterShopAdminController::class, 'showCategory'])->name('admin.itemshop.showCategory');
    Route::get('/admin/itemshop/cat/{catClassName}/create', [ItemCharacterShopAdminController::class, 'create'])->name('admin.itemshop.showCategory.create');
    Route::post('/admin/itemshop/edit/cat/{catClassName}/to/{id}', [ItemCharacterShopAdminController::class, 'editSave'])->name('admin.itemshop.edit');

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
