<?php

namespace App\Models\V1;

use App\Enums\V1\UserStatus;
use App\Enums\V1\UserType;
use Illuminate\Http\Request;
use App\Models\V1\{Coin,Signup,Setting};
use App\Http\Requests\V1\CreateUserRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'type',
        'date_of_birth',
        'country',
        'email',
        'password',
        'status',
        'recovery_attempts',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    /**
     * @param string $value
     *
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function recoveryKey()
    {
        return $this->hasOne(RecoveryKey::class);
    }

    public function store(CreateUserRequest $request): self
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'type' => UserType::User,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'email' => $request->email,
            'password' => $request->password,
            'status' => UserStatus::Active,
        ]);
        // REGISTRATION STATUS UPDATION -  STEP:1
        $signup = $this->signup;
        if($signup){
            $signup->step_count+=1;
            $signup->save();
        }

        Signup::create(['step_count'=>1,'user_id'=>$user->id]);

        return $user;

    }













    public function showPieChartData(User $user, Request $request){
        $filterByCondition = $request->filterBy;
        $wallets = Wallet::select(['coin_id', 'balance'])
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function ($wallet) {
                return [$wallet->coin->name => $wallet->balance];
            })
            ->map(function ($e) {
                return $e->sum();
            })->toArray();
        if($filterByCondition==NULL || $filterByCondition=='coins'){
            return response([
                'message'=>'success',
                'data'=>$wallets
            ],200);

        }
        if($filterByCondition=='currency'){
            $coinDataAll = Coin::all();
            $result = [];
            $coinShortName = [];
            foreach($wallets as $key1=>$value1){
                foreach($coinDataAll as $coinData){
                    if(strtolower($coinData->name) == strtolower($key1)){
                        array_push($coinShortName,$coinData->coin_id);
                    }
                }
            }
            foreach($wallets as $key1=>$value1){
                foreach($coinShortName as $shortName){
                    $primaryCurrency = Setting::whereUserId($user->id)->first()->primary_currency;
                    $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.exchange_url');
                    $baseURLId1Replace = str_replace('{id1}', $shortName, $baseURL);
                    $baseURLId1Replaced = $baseURLId1Replace;
                    $baseURLIdReplaced = str_replace('{id2}', $primaryCurrency, $baseURLId1Replaced);
                    $baseURLwithHeaders = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($baseURLIdReplaced);
                    $primaryBalance = $baseURLwithHeaders['rate'] * $wallets[$key1];
                    $result[$shortName] = $primaryBalance;
                }
            }
            return response([
                'message'=>'success',
                'data'=>$result
            ],200);
            
        }
    }















    public function showUserCoins(User $user){
        $coinNames = Wallet::whereUserId($user->id)->get();
        $coinIds = [];
        foreach ($coinNames as $coinName){
            array_push($coinIds,$coinName->coin_id);
        }
        $coinIds =array_unique($coinIds);
        $coinList=[];
        foreach ($coinIds as $coinId){
            $coinName = Coin::whereId($coinId)->first();
            $coinName = $coinName->name;
            array_push($coinList,$coinName);
        }
        return response([
            'message'=>'success',
            'data'=>$coinList
        ],200);        
    }












    public function pieChartFilter(){
        $filters = ['coins','currency'];
        return response([
            'message'=>'success',
            'data'=>$filters
        ],200); 
    }









    public function realTimeGraphFilter(){
        $filters = ['weekly','monthly','yearly'];
        return response([
            'message'=>'success',
            'data'=>$filters
        ],200); 
    }





    // public function index(User $user, Request $request){

    //     $coinNameFromUser = $request->coin_name;
    //     //return $coinNameFromUser;
    //     $range = $request->range;

    //     $coinDataAll = Coin::all();
    //     foreach($coinDataAll as $coinData){
    //         if($coinNameFromUser == $coinData->name){
    //             $coinNameResult = $coinData->coin_id;
    //         }
    //     }
    //     $coinNameResult = $coinNameResult;
    //     // return $coinNameResult;

    //     $end_date = Carbon::now()->format('Y-m-d');
    //     $end_date = $end_date."T".Carbon::now()->format('H:i:m');
        
    //     $realTimeDataDisplay = [];

    //     if($range=="weekly"){
    //         $range = '7DAY';
    //         $start_date = Carbon::now()->subYear(1);
    //         $start_date  = str_replace(' ','T',$start_date);
            
    //         $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.realtime_url');

    //         $baseURLCoin1Replace = str_replace('{coin1}', $coinNameResult, $baseURL);
    //         $baseURLCoin1Replaced = $baseURLCoin1Replace;

    //         $baseURLRangeReplace = str_replace('{range}', $range, $baseURLCoin1Replaced);
    //         $baseURLRangeReplaced = $baseURLRangeReplace;

    //         $baseURLStartDateReplace = str_replace('{start_date}', $start_date, $baseURLRangeReplaced);
    //         $baseURLStartDateReplaced = $baseURLStartDateReplace;

    //         $finalBaseURL = str_replace('{end_date}', $end_date, $baseURLStartDateReplaced);

    //         $finalBaseURLResponse = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($finalBaseURL);
            
    //         $finalBaseURLResponse = json_decode($finalBaseURLResponse);
    //         // return $finalBaseURLResponse;
    //         foreach($finalBaseURLResponse as $response){
    //             array_push($realTimeDataDisplay,[
    //                 'date'=>$response->time_period_end,
    //                 'price'=>$response->rate_close
    //             ]);
    //         }
    //         return response([
    //             'message'=>'success',
    //             'result'=>[
    //                 'coin'=>$coinNameFromUser,
    //                 'data'=>$realTimeDataDisplay
    //             ]
                
    //         ],200);

    //     }
    //     if($range=='monthly'){
    //         $range = '10DAY';
    //         $start_date = Carbon::now()->subYear(1);
    //         $start_date  = str_replace(' ','T',$start_date);
            
    //         $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.realtime_url');

    //         $baseURLCoin1Replace = str_replace('{coin1}', $coinNameResult, $baseURL);
    //         $baseURLCoin1Replaced = $baseURLCoin1Replace;

    //         $baseURLRangeReplace = str_replace('{range}', $range, $baseURLCoin1Replaced);
    //         $baseURLRangeReplaced = $baseURLRangeReplace;

    //         $baseURLStartDateReplace = str_replace('{start_date}', $start_date, $baseURLRangeReplaced);
    //         $baseURLStartDateReplaced = $baseURLStartDateReplace;

    //         $baseURLwithAllIdsReplaced = str_replace('{end_date}', $end_date, $baseURLStartDateReplaced);

    //         $finalURL = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($baseURLwithAllIdsReplaced);
            
    //         $finalURL = json_decode($finalURL);

    //         $priceArrayList = [];
    //         foreach($finalURL as $response){
    //             array_push($priceArrayList,$response->rate_close);
    //         }

    //         $priceArraySum = [];
    //         $sum = 0;
    //         $count = 0;
    //         for($i=1;$i<count($priceArrayList);$i++){
    //             $count=$i+1;
    //             $sum = $sum + $priceArrayList[$i];
    //             if($i%3==0){
    //                 array_push($priceArraySum,$sum/3);
    //                 $sum = 0;
    //             }
    //         }
    //         $everyMonth = [];
    //         $endDate = Carbon::now();
    //         $startDate = Carbon::now()->subYear(1);
    //         for($i=0;$i<=count($priceArraySum)-1;$i++){
    //             $startDate = $startDate->addMonths(1);
    //             array_push($everyMonth,$startDate->format('Y-m-d'));
    //         }
    //         $result = [];
    //         for($i=0;$i<count($priceArraySum);$i++){
    //             array_push($result,[
    //                 'date'=>$everyMonth[$i],
    //                 'price'=>$priceArraySum[$i]
    //             ]);    
    //         }
    //         return response([
    //             'message'=>'success',
    //             'result'=>[
    //                 'data'=>$result
    //             ]
                
    //         ],200);
    //     }


    //     if($range=='yearly'){

    //         $range = '10DAY';

    //         $start_date = Carbon::now()->format('Y');
    //         $presentYear = Carbon::now()->format('Y');
    //         $start_date = Carbon::create($presentYear, 1, 1, 0);
    //         $start_date = $start_date->toDateTimeString();
    //         $start_date  = str_replace(' ','T',$start_date);
    //         return $start_date;
            
    //         $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.realtime_url');

    //         $baseURLCoin1Replace = str_replace('{coin1}', $coinNameResult, $baseURL);
    //         $baseURLCoin1Replaced = $baseURLCoin1Replace;

    //         $baseURLRangeReplace = str_replace('{range}', $range, $baseURLCoin1Replaced);
    //         $baseURLRangeReplaced = $baseURLRangeReplace;

    //         $baseURLStartDateReplace = str_replace('{start_date}', $start_date, $baseURLRangeReplaced);

    //         $baseURLStartDateReplaced = $baseURLStartDateReplace;
    //        // return $baseURLStartDateReplaced;

    //         $baseURLwithAllIdsReplaced = str_replace('{end_date}', $end_date, $baseURLStartDateReplaced);

    //         $result = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($baseURLwithAllIdsReplaced);
            
    //         $result = json_decode($result);
    //         //return $result;
    //         $priceArrayList = [];
    //         foreach($result as $response){
    //             array_push($priceArrayList,$response->rate_close);
    //         }

    //         $priceArraySum = [];
    //         $sum = 0;
    //         $count = 0;
    //         for($i=1;$i<count($priceArrayList);$i++){
    //             $count=$i+1;
    //             $sum = $sum + $priceArrayList[$i];
    //             if($i%3==0){
    //                 array_push($priceArraySum,$sum/3);
    //                 $sum = 0;
    //             }
    //         }
    //         $everyMonth = [];
    //         $endDate = Carbon::now();
    //         $startDate = Carbon::now()->subYear(2);
    //         for($i=0;$i<=count($priceArraySum)-1;$i++){
    //             $startDate = $startDate->addMonths(1);
    //             array_push($everyMonth,$startDate->format('Y'));
    //         }
    //         $result = [];
    //         for($i=0;$i<count($priceArraySum);$i++){
    //             array_push($result,[
    //                 'date'=>$everyMonth[$i],
    //                 'price'=>$priceArraySum[$i]
    //             ]);    
    //         }


    //         return $result;
    //         // return response([
    //         //     'message'=>'success',
    //         //     'result'=>[
    //         //         'data'=>$result
    //         //     ]
                
    //         // ],200);



    //     }

    // }

    public function commonDataRealTime($coinNameResult,$range,$start_date,$end_date){
        // return $start_date;
        $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.realtime_url');

        $baseURLCoin1Replace = str_replace('{coin1}', $coinNameResult, $baseURL);
        $baseURLCoin1Replaced = $baseURLCoin1Replace;

        $baseURLRangeReplace = str_replace('{range}', $range, $baseURLCoin1Replaced);
        $baseURLRangeReplaced = $baseURLRangeReplace;

        $baseURLStartDateReplace = str_replace('{start_date}', $start_date, $baseURLRangeReplaced);
        $baseURLStartDateReplaced = $baseURLStartDateReplace;

        $finalBaseURL = str_replace('{end_date}', $end_date, $baseURLStartDateReplaced);

        $finalBaseURLResponse = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($finalBaseURL);

        return $finalBaseURLResponse;
        
    }


    public function index(User $user, Request $request){

        $coinNameFromUser = $request->coin_name;
        //return $coinNameFromUser;
        $range = $request->range;

        $coinDataAll = Coin::all();
        foreach($coinDataAll as $coinData){
            if($coinNameFromUser == $coinData->name){
                $coinNameResult = $coinData->coin_id;
            }
        }
        $coinNameResult = $coinNameResult;
        // return $coinNameResult;

        $end_date = Carbon::now()->format('Y-m-d');
        $end_date = $end_date."T".Carbon::now()->format('H:i:m');
        $realTimeDataDisplay = [];


        if($range=='1DAY'){
            $range = '1HRS';
            $start_date = Carbon::now()->subDay(1);
            $start_date  = str_replace(' ','T',$start_date);        
            $finalBaseURLResponse = json_decode($this->commonDataRealTime($coinNameResult,$range,$start_date,$end_date));
            foreach($finalBaseURLResponse as $response){
                array_push($realTimeDataDisplay,[
                    'date'=>$response->time_period_end,
                    'price'=>$response->rate_close
                ]);
            }
            return response([
                'message'=>'success',
                'result'=>[
                    'coin'=>$coinNameFromUser,
                    'data'=>$realTimeDataDisplay
                ]
                
            ],200);
        }


        if($range=='Week'){
            $range = '1DAY';
            $start_date = Carbon::now()->subDay(6);
            $start_date  = str_replace(' ','T',$start_date);
            $finalBaseURLResponse = json_decode($this->commonDataRealTime($coinNameResult,$range,$start_date,$end_date));
            foreach($finalBaseURLResponse as $response){
                array_push($realTimeDataDisplay,[
                    'date'=>$response->time_period_end,
                    'price'=>$response->rate_close
                ]);
            }
            return response([
                'message'=>'success',
                'result'=>[
                    'coin'=>$coinNameFromUser,
                    'data'=>$realTimeDataDisplay
                ]
                
            ],200);
        }

        if($range=='Month'){
            $range = '7DAY';
            $start_date = Carbon::now()->subMonth(1);
            $start_date  = str_replace(' ','T',$start_date);
            $finalBaseURLResponse = json_decode($this->commonDataRealTime($coinNameResult,$range,$start_date,$end_date));
            foreach($finalBaseURLResponse as $response){
                array_push($realTimeDataDisplay,[
                    'date'=>$response->time_period_end,
                    'price'=>$response->rate_close
                ]);
            }
            return response([
                'message'=>'success',
                'result'=>[
                    'coin'=>$coinNameFromUser,
                    'data'=>$realTimeDataDisplay
                ]
                
            ],200);
        }
        if($range=='Year'){
            $range = '7DAY';
            $start_date = Carbon::now()->subYear(1);

            $prevYearMonth = $start_date->format('Y-m');

            $start_date  = str_replace(' ','T',$start_date);
            $finalBaseURLResponse = json_decode($this->commonDataRealTime($coinNameResult,$range,$start_date,$end_date));
            // return $finalBaseURLResponse;

            $dataIndex = [];
            foreach($finalBaseURLResponse as $response){
                array_push($dataIndex,Carbon::parse($response->time_period_end)->format('Y-m'));
                array_push($realTimeDataDisplay,[
                    'date'=>Carbon::parse($response->time_period_end)->format('Y-m'),
                    'price'=>$response->rate_close
                ]);
            }
            $dataIndex = array_unique($dataIndex);
            $dataIndexUnique = [];
            foreach($dataIndex as $key=>$value){
                array_push($dataIndexUnique, $value);
            }
            //return $dataIndexUnique;
            //return $realTimeDataDisplay;
            $finalResult = [];
            foreach($dataIndexUnique as $date){
                $count = 0;
                $sum = 0;
                foreach($realTimeDataDisplay as $response){
                    if($response['date']==$date){
                        $count++;
                        $sum+=$response['price'];

                    }
                }
                $avg = $sum/$count;
                array_push($finalResult,[$date=>$avg]);
            }

            return response([
                'message'=>'success',
                'result'=>$finalResult
            ],200);


            // return response([
            //     'message'=>'success',
            //     'result'=>[
            //         'coin'=>$coinNameFromUser,
            //         'data'=>$realTimeDataDisplay
            //     ]
                
            // ],200);
        }
    }




























    public function recoveryKeys()
    {
        return $this->hasMany(RecoveryKey::class, 'user_id', 'id');
    }

    public function signUp()
    {
        return $this->hasOne(Signup::class);
    }

    public function wallet(){
        return $this->hasMany(Wallet::class);
    }
}