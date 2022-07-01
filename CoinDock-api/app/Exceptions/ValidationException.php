<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as BaseValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends BaseValidationException
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response(
            ['message' => $this->message, 'errors' => $this->errors()],
            Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }
}