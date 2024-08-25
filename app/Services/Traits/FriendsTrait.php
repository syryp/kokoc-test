<?php

namespace App\Services\Traits;

use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Support\Collection;

trait FriendsTrait
{
    public function friendsList(int $userId): Collection
    {
        return app(UserRepositoryContract::class)
            ->getFriends($userId)
            ->pluck('friends')
            ->collapse();
    }

    public function friendsFriendsList(int $userId): Collection
    {
        return app(UserRepositoryContract::class)
            ->getFriendsFriends($userId)
            ->pluck('friends')
            ->collapse()
            ->pluck('friends')
            ->collapse()
            ->unique('id');
    }

    public function toggleFriend(array $params): void
    {
        //Тут можно усложнить логику, но я решил сделать попроще и определение "друга" присваивается тому у кого запрашивается дружба
        app(UserRepositoryContract::class)->toggleFriend($params['user_id'], $params['friend_id']);
    }
}
