<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;

class CreateUserRequest extends AbstractRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ];
    }
}
