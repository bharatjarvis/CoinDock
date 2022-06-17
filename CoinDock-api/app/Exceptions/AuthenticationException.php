<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException as BaseAuthenticationException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends BaseAuthenticationException
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response(['message' => $this->message], Response::HTTP_UNAUTHORIZED);
    }
}