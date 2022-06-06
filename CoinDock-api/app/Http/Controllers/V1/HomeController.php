<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\V1\User;
use App\Models\V1\Wallet;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function  showDashboard(){

        $data= Wallet::select(['coin_id',
                            'balance',
                            ])
                            ->get();
        $grouped = $data->groupBy('coin_id')
                        ->map(function ($row) {
 
            return $row->sum('balance') ;

        });
        return $grouped;
    }

}
