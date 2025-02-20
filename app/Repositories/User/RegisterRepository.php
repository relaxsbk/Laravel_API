<?php

namespace App\Repositories\User;

use App\Models\User;

class RegisterRepository
{
    public function register(array $data)
    {
        return User::query()->create($data);
    }

}
