<?php

namespace App\Http\Controllers\V1;

use Symfony\Component\HttpFoundation\Response;
use App\Enums\V1\TimePeriod;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GraphRequest;
use App\Models\V1\User;
class GraphController extends Controller
{
    public function filter(User $user)
    { 
        return response(
            [
                'message' => 'success',
                'results' => TimePeriod::getInstances()
            ],
            Response::HTTP_OK
        ); 
        
    }

    public function getCoinIds(User $user)
    {
        $result = $user->uniqueCoins()->pluck('name');
        $result->prepend('All');
        return response(
            [
                'message' => 'success',
                'results' => $result
            ],
            Response::HTTP_OK
        ); 
    }

    public function show(User $user, GraphRequest $request)
    {
        return response(
            [
                'message' => 'success',
                'results' => $user->graph($request)
            ],
            Response::HTTP_OK
        );
    } 
}