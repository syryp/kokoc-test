<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Support\Collection;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    public function toggleFriend(int $userId, int $friendId): void
    {
        $user = $this->model->newQuery()->find($userId);

        $friendsIds = $user->friends()->pluck('friend_id')->toArray();

        in_array($friendId, $friendsIds)
            ? $friendsIds = array_diff($friendsIds, [$friendId])
            : array_push($friendsIds, $friendId);

        $user->friends()->sync($friendsIds);
    }

    public function getFriends(int $userId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('users.id', $userId)
            ->with('friends')
            ->get();
    }

    public function getFriendsFriends(int $userId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('users.id', $userId)
            ->with(['friends.friends' => function ($query) use($userId) {
                //Исключаем основного юзера
                $query->where('friends.friend_id', '!=', $userId);
            }])
            ->get();
    }
}
