<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ChartRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\V1\User;
use Illuminate\Http\Request;

class PieChartController extends Controller
{
    public function show(User $user, ChartRequest $request)
    {
        return response(
            [
                'message' => 'success',
                'results' => $user->chartData($request)
            ],
            Response::HTTP_OK
        );
    }

    public function filter(User $user)
    {
        return response(
            [
                'message' => 'success',
                'results' => ['coins','currency']
            ],
            Response::HTTP_OK
        );
    }
}
