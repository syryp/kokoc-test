<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;

class ToggleFriendRequest extends AbstractRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'friend_id' => 'required|exists:users,id',
        ];
    }
}
