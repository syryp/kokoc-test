<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;

class UserList extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return null|array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
