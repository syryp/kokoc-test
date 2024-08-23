<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user',
],
    function () {
    //CRUD
        Route::post('create', [UserController::class, 'create'])->name('user.create');
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::delete('{user_id}', [UserController::class, 'delete'])->name('user.delete');

        Route::get('list', [UserController::class, 'list'])->name('user.list');
        Route::get('{user_id}', [UserController::class, 'detail'])->name('user.detail');

    //Friends
        Route::post('toggle-friend', [UserController::class, 'toggleFriend'])->name('user.toggle-friend');
        Route::get('{user_id}/friends', [UserController::class, 'friendsList'])->name('user.friends');
        Route::get('{user_id}/friends-friends', [UserController::class, 'friendsFriendsList'])->name('user.friends-friends');
    }
);
