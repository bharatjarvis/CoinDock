<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class WalletCreationException extends Exception
{
    public function render($request)
    {
        return response(['message' => $this->message], Response::HTTP_BAD_REQUEST);
    }
}