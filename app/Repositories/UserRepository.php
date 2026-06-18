<?php

namespace App\repositories;

use App\Models\User;
use function Pest\Laravel\get;

class UserRepository extends MainRepository
{

    public function OneByUsername($username, $with) {
        return User::with($with)
            ->where('name', '=', $username)
            ->first();
    }
}
