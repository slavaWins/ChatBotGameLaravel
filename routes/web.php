<?php

use Illuminate\Support\Facades\Route;
use SlavaWins\AuthSms\Library\AuthSmsRoute;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


AuthSmsRoute::routes();


Route::get('/shop/{shop}', [\app\Http\Controllers\trash\ShopController::class, 'show'])->name('shop.show');
Route::get('/basket-raw', [\app\Http\Controllers\trash\BasketController::class, 'cardRaw'])->name('card.raw');


Route::group(['middleware' => ['auth']], function () {


    Route::get('/messagebox', [App\Http\Controllers\MessageBoxController::class, 'index'])->name('messagebox.index');
    Route::get('/messagebox/action/clear-history', [App\Http\Controllers\MessageBoxController::class, 'ClearHistory'])->name('messagebox.action.clearmessage');
    Route::get('/messagebox/action/autotest', [App\Http\Controllers\MessageBoxController::class, 'AutoTest'])->name('messagebox.action.autotest');
    Route::get('/messagebox/action/resetuser', [App\Http\Controllers\MessageBoxController::class, 'Resetuser'])->name('messagebox.action.resetuser');
    Route::any('/api/messagebox/send', [App\Http\Controllers\MessageBoxController::class, 'SendMessage']);


    Route::get('/admin', [App\Http\Controllers\Admin\AdminPageController::class, 'index'])->name('admin');
    Route::get('/admin/shop/list', [App\Http\Controllers\Admin\ShopAdminController::class, 'index'])->name('admin.shop.list');
    Route::get('/admin/shop/create/{shop}', [App\Http\Controllers\Admin\ShopAdminController::class, 'edit'])->name('admin.shop.create');
    Route::post('/admin/shop/create/{shop}', [App\Http\Controllers\Admin\ShopAdminController::class, 'store'])->name('admin.shop.create.post');
    Route::get('/admin/users/list', [App\Http\Controllers\Admin\Users\UsersAdminController::class, 'index'])->name('admin.user.list');
    Route::get('/admin/users/show/{userShow}', [App\Http\Controllers\Admin\Users\UsersAdminController::class, 'show'])->name('admin.user.show');
    Route::get('/admin/users/history/{userShow}', [App\Http\Controllers\Admin\Users\UsersAdminController::class, 'history'])->name('admin.user.history');
    Route::get('/admin/character/show/{character}', [App\Http\Controllers\Admin\Character\CharacterAdminController::class, 'show'])->name('admin.character.show');
    Route::post('/admin/character/edit/{character}', [App\Http\Controllers\Admin\Character\CharacterAdminController::class, 'update'])->name('admin.character.edit');

    /*
    Route::get('/admin/orders/list', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderList'])->name('admin.order.list');
    Route::get('/admin/orders/edit/{order}', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderDeteils'])->name('admin.order.edit');
    Route::post('/admin/orders/edit/{order}', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderEditSave'])->name('admin.order.edit.save');
    Route::post('/admin/orders/statusedit/{order}', [App\Http\Controllers\Admin\AdminPageController::class, 'OrderEditStatus'])->name('admin.order.edit.status');
*/
    Route::get('/pay/test', [App\Http\Controllers\Tarifiner\TarifinerController::class, 'PayTestPage'])->name('Tarifiner.PayTest');
    Route::get('/plans', [App\Http\Controllers\Tarifiner\TarifinerController::class, 'PlansPage'])->name('Tarifiner.Tarifs');


    Route::get('/project/create', [\app\Http\Controllers\trash\ProjectController::class, 'create'])->name('project.create');
    Route::post('/project/create', [\app\Http\Controllers\trash\ProjectController::class, 'store'])->name('project.create.store');
    Route::get('/project/show/{project}', [\app\Http\Controllers\trash\ProjectController::class, 'show'])->name('project.show');
    Route::get('/editor/{project}', [\app\Http\Controllers\trash\EditorController::class, 'show'])->name('editor.show');


    Route::post('/api/editor/add_baserow', [\app\Http\Controllers\trash\EditorController::class, 'AddBaseRow']);
    Route::post('/api/editor/remove_baserow', [\app\Http\Controllers\trash\EditorController::class, 'RemoveBaseRow']);
    Route::post('/api/editor/update_parameters', [\app\Http\Controllers\trash\EditorController::class, 'BaseRowParametersUpdate']);
    Route::post('/api/editor/update_textareas', [\app\Http\Controllers\trash\EditorController::class, 'TextareaUpdates']);
    Route::post('/api/editor/map_sort_blocks', [\app\Http\Controllers\trash\EditorController::class, 'MapSortBlocksUpdates']);

    Route::post('/api/editor/block_add', [\app\Http\Controllers\trash\EditorController::class, 'BlockAdd']);
    Route::post('/api/editor/block_remove', [\app\Http\Controllers\trash\EditorController::class, 'BlockAdd']);
    //        Route::post('/api/editor/save_element', [App\Http\Controllers\EditorController::class, 'BlockAdd']);


    Route::get('/profile', [App\Http\Controllers\UserProfile::class, 'index'])->name('profile');
    Route::post('/profile-update', [App\Http\Controllers\UserProfile::class, 'RequestUpdate'])->name('profile-update');


    Route::get('/basket-api/add/{product}/{increment}', [\app\Http\Controllers\trash\BasketController::class, 'add'])->name('basket.api.add');
    Route::get('/basket-api/clear', [\app\Http\Controllers\trash\BasketController::class, 'clear'])->name('basket.api.clear');


    Route::get('/id{user}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');


    Route::get('/order/show/{order}', [\app\Http\Controllers\trash\OrderController::class, 'show'])->name('order.show');
    Route::get('/order/history', [\app\Http\Controllers\trash\OrderController::class, 'history'])->name('order.history');
    Route::get('/order/create', [\app\Http\Controllers\trash\OrderController::class, 'create'])->name('order.create');
    Route::post('/order/create', [\app\Http\Controllers\trash\OrderController::class, 'store'])->name('order.create.post');

});
