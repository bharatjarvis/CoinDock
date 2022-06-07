<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V1\{User,SignUp};

class SignupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

        $signup = SignUp::find($user->id);

        $resultArr = [
            'step_1_completed' => false,
            'step_2_completed' => false,
            'step_3_completed' => false
        ];

        $stepCount = $signup->step_count;

        if($stepCount == 0) {
            return response([
                'message' => 'Signup not completed',
                'results' => [
                    'step_details' => $resultArr
                ]
            ], 
            200);
        }

        foreach(range(1, $stepCount) as $i) {
            $resultArr["step_{$i}_completed"] = true;
        }

        return response(['message' => 'Signup details',
            'results' => [
                'step_details' => $resultArr
            ]]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
