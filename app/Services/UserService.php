<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Services\Traits\FriendsTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService implements UserServiceContract
{
    use FriendsTrait;

    public function create(array $params): Model
    {
        return app(UserRepositoryContract::class)->create($params);
    }

    public function update(array $params): Model
    {
        $user = app(UserRepositoryContract::class)->find(['id' => $params['user_id']]);

        return app(UserRepositoryContract::class)->update($user, [
            'name' => $params['name']
        ]);
    }

    public function delete(int $userId): void

    {
        app(UserRepositoryContract::class)->delete($userId);
    }

    public function detail(int $userId): ?Model
    {
        return app(UserRepositoryContract::class)->find(['id' => $userId]);
    }

    public function list(): Collection
    {
        return app(UserRepositoryContract::class)->getList();
    }
}
