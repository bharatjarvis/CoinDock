<?php

namespace App\Models\V1;

use App\Enums\V1\TimePeriod;
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
use Illuminate\Support\Arr;
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

    public function showPieChartData(Request $request){
        $filterBy = $request->filterBy;
        $wallets = $this->wallets()->select(['coin_id', 'balance'])
            ->get()
            ->mapToGroups(function ($wallet) {
                return [$wallet->coin->coin_id => $wallet->balance];
            })->map(function ($e) {
                return $e->sum();
            })->toArray();

        if($filterBy == null || $filterBy == 'coins'){
            return $wallets;
        }

        $result = [];
        if($filterBy == 'currency'){
            foreach($wallets as $key=>$value){
                $primaryCurrency = $this->setting()->select('primary_currency')
                ->get()
                ->map(function ($e) {
                    return $e->primary_currency;
                });
                $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.exchange_url');
                $baseURLIdReplaced = str_replace(['{fromCoin}','{toCoin}'],[$key,$primaryCurrency[0]],$baseURL);
                $response = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($baseURLIdReplaced);
                $primaryBalance = Arr::get($response, 'rate', null)* $wallets[$key];
                $result[$key] = $primaryBalance;
            }
            return $result; 
        }
        return $result;
    }


    public function commonDataRealTime(string $coinId, string $range,string $startDate,string $endDate){
        $baseURL = config('cryptohistoricaldata.coin.api_url').config('cryptohistoricaldata.coin.realtime_url');
        $baseURLIdReplaced = str_replace(['{coin1}','{range}','{start_date}','{end_date}'],[$coinId,$range,$startDate,$endDate],$baseURL);
        $response = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin.api_key')])->get($baseURLIdReplaced);
        return json_decode($response);
    }


    public function returnCoinId($coinId){
        if($coinId) {
            return $this->wallets->map(function($wallet) use($coinId) {
                return $wallet->coin()->whereCoinId($coinId)->first();    
            })->unique('coin_id')->pluck('coin_id')->filter();
        }
        return $this->uniqueCoins()->pluck('coin_id');
    }

    public function uniqueCoins(){
        return $this->wallets->map(fn($wallet) => $wallet->coin)->unique('coin_id');
    }

    
    public function dayDataForAllCoins($range, $startDate, $endDate, $coinId)
    {
        $realTimeData = [];
        $coinIds = $this->returnCoinId($coinId);
        foreach($coinIds as $coinId){
            $response = $this->commonDataRealTime($coinId, $range, $startDate, $endDate);
            $realTimeData[$coinId] = array_column($response, 'rate_close', 'time_period_end'); 
        }
        return $realTimeData;
    }

    public function getCoin($coinNameFromUser){
        $coinIdGet = Coin::select('coin_id')->where('name','=',$coinNameFromUser)->get();
        $coinNameFinal = "";
        foreach($coinIdGet as $coin){
            $coinNameFinal = $coin->coin_id;
        }
        return $coinNameFinal;
    }


    public function index( Request $request){
        $coinId = Arr::get($request, 'coin_id');
        $timePeriod = $request->range;
        $endDate = str_replace(' ','T', Carbon::now()->toDateTimeString());
        
            switch($timePeriod) {
                case TimePeriod::Day: 
                    $range = '1HRS';
                    $startDate = str_replace(' ','T', Carbon::now()->subDay(1)->toDateTimeString());
                    return $this->dayDataForAllCoins($range, $startDate, $endDate, $coinId);
                    break;
                case TimePeriod::Weekly:
                    $range = '1DAY';
                    $startDate = str_replace(' ','T', Carbon::now()->subDay(6)->toDateTimeString());
                    return $this->dayDataForAllCoins($range, $startDate, $endDate, $coinId);
                    break;
                case TimePeriod::Monthly:
                    $range = '7DAY';
                    $startDate = str_replace(' ','T', Carbon::now()->subMonth(1)->toDateTimeString());
                    return $this->dayDataForAllCoins($range, $startDate, $endDate, $coinId);
                    break;
                case TimePeriod::Yearly:
                    $range = '7DAY';
                    $startDate = str_replace(' ','T', Carbon::now()->subYear(1)->toDateTimeString());
                    $response = $this->dayDataForAllCoins($range, $startDate, $endDate, $coinId);

                    $realTimeData = [];
                    $allDatePriceIndex = [];
                    foreach($response as $coinId => $coinData){
                        foreach($coinData as $date=>$price){
                            array_push($allDatePriceIndex,[
                                'date'=>Carbon::parse($date)->format('Y-m'),
                                'price'=>$price
                            ]);
                        }
                        $dataIndex = array_unique(array_column($allDatePriceIndex,'date'));

                        $finalResult = [];
                        foreach($dataIndex as $date){
                            $count = 0;
                            $sum = 0;
                            foreach($allDatePriceIndex as $response){
                                if($response['date']==$date){
                                    $count++;
                                    $sum+=$response['price'];
                                }
                            }
                            $avg = $sum/$count;
                            $finalResult[$date] = $avg;
                        }
                        $realTimeData[$coinId] = $finalResult;
                    }
                return $realTimeData;
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

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}