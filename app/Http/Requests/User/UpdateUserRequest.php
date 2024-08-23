<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;

class UpdateUserRequest extends AbstractRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
        ];
    }
}
