<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Http\Presenters\DataResultPresenter;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\ToggleFriendRequest;
use App\Http\Requests\User\TransactionCallbackRequest;
use App\Http\Requests\User\TransactionDetailRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\CreateTransaction;
use App\Http\Resources\User\FriendList;
use App\Http\Resources\User\UserDetail;
use App\Http\Resources\User\UserList;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        return new DataResultPresenter(new UserDetail(app(UserServiceContract::class)->create($request->validated())));
    }

    public function update(UpdateUserRequest $request)
    {
        return new DataResultPresenter(new UserDetail(app(UserServiceContract::class)->update($request->validated())));
    }

    public function delete(int $user_id)
    {
        app(UserServiceContract::class)->delete($user_id);

        return new DataResultPresenter([
            'success' => true,
        ]);
    }

    public function detail(int $user_id)
    {
        return new UserDetail(app(UserServiceContract::class)->detail($user_id));
    }

    public function list()
    {
        return new DataResultPresenter(UserList::collection(app(UserServiceContract::class)->list()));
    }

    public function toggleFriend(ToggleFriendRequest $request) {
        app(UserServiceContract::class)->toggleFriend($request->validated());

        return new DataResultPresenter([
            'success' => true,
        ]);
    }

    public function friendsList(int $user_id) {
        return new DataResultPresenter(UserList::collection(app(UserServiceContract::class)->friendsList($user_id)));
    }

    public function friendsFriendsList(int $user_id) {
        return new DataResultPresenter(UserList::collection(app(UserServiceContract::class)->friendsFriendsList($user_id)));
    }
}
