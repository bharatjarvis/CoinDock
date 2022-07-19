<?php

namespace App\Policies;

use App\Exceptions\AuthenticationException;
use App\Models\V1\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $authUser, User $user){
        return $authUser->id === $user->id ?: throw new AuthenticationException('unauthorized user');;
    }

}
