<?php

namespace App\Policies;

use App\Exceptions\AuthenticationException;
use App\Models\V1\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index( $authUser, User $user){
        return $authUser->id === $user->id ?: throw new AuthenticationException('unauthorized user');;
    }

}