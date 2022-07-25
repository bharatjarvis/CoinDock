<?php

namespace App\Models\V1;

use App\Enums\V1\TimePeriod;
use App\Enums\V1\UserStatus;
use App\Enums\V1\UserType;
use App\Exceptions\ApiKeyException;
use App\Http\Requests\V1\ChartRequest;
use App\Models\V1\{Signup, Setting};
use App\Models\V1\{Coin};
use App\Http\Requests\V1\CreateUserRequest;
use App\Http\Requests\V1\updatePasswordRequest;
use App\Http\Requests\V1\UpdateProfileRequest;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\V1\GraphRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Models\V1\Wallet;
use Symfony\Component\HttpFoundation\Response;

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
            'title'
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

        //User Titles
        public static function titles()
        {
            return ['Mr.', 'Ms.', 'Mrs.', 'Mx.'];
        }

        public static function countries()
        {
            return config('countries.countries');
        }

        public function recoveryKey()
        {
            return $this->hasOne(RecoveryKey::class);
        }

        public static function store(CreateUserRequest $request): self
        {
            $user = self::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'type' => UserType::User,
                'date_of_birth' => $request->date_of_birth,
                'country' => $request->country,
                'email' => $request->email,
                'password' => $request->password,
                'status' => UserStatus::Active,
                'title' => $request->title,

            ]);

            //Adding default Currency settings for user
            Setting::create([
                'user_id' => $user->id,
                'primary_currency' => config('countries.default_country.currency'),
                'secondary_currency' => 'USD'
            ]);

            // REGISTRATION STATUS UPDATION -  STEP:1
            $signup = $user->signup;
            if ($signup) {
                $signup->step_count += 1;
                $signup->save();
            }

            Signup::create(['step_count' => 1, 'user_id' => $user->id]);

            return $user;
        }

        public function chartData(ChartRequest $request): array
        {
            $filterBy = $request->filter_by;
            $wallets = $this->wallets()->select(['coin_id', 'coins'])
                ->get()
                ->mapToGroups(function ($wallet) {
                    return [$wallet->coin->coin_id => $wallet->coins];
                })->map(function ($coins) {
                    return $coins->sum();
                })->toArray();

            if ($filterBy == null || $filterBy == 'coins') {
                return $wallets;
            }

            $result = [];

            if ($filterBy == 'currency') {

                foreach ($wallets as $key => $value) {

                    $primaryCurrency = $this->setting->primary_currency;

                    $baseURL = config('coin.coin.api_url') . config('coin.coin.exchange_url');

                    $baseURLIdReplaced = str_replace(
                        ['{from}', '{to}'],
                        [$key, $primaryCurrency],
                        $baseURL
                    );


                    try {
                        $response = Http::withHeaders([
                            'X-CoinAPI-Key' => config('coin.coin.api_key')
                        ])->get($baseURLIdReplaced)['rate'];
                    } catch (\Throwable $th) {
                        throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
                    }

                    $primaryBalance = $response * $wallets[$key];

                    $result[$key] = $primaryBalance;
                }
            }

            return $result;
        }

        public function historicalData(string $coinId, string $range, string $startDate, string $endDate): array
        {
            $baseURL = config('coin.coin.api_url') . config('coin.coin.realtime_url');

            $baseURLIdReplaced = str_replace(
                ['{coin1}', '{range}', '{start_date}', '{end_date}'],
                [$coinId, $range, $startDate, $endDate],
                $baseURL
            );

            try {
                $response = Http::withHeaders(
                    ['X-CoinAPI-Key' => config('coin.coin.api_key')]
                )->get($baseURLIdReplaced);
                return json_decode($response);
            } catch (\Throwable $th) {

                throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
            }
        }


        public function getCoinId($coinId): array|collection
        {
            if ($coinId != 'Coins') {
                return $this->wallets->map(function ($wallet) use ($coinId) {
                    return $wallet->coin()->whereCoinId($coinId)->first();
                })->unique('coin_id')->pluck('coin_id')->filter();
            }
            return $this->uniqueCoins()->pluck('coin_id')->toArray();
        }

        public function uniqueCoins(): collection
        {
            return $this->wallets->map(fn ($wallet) => $wallet->coin)->unique('coin_id');
        }


        public function graphData(string $range, string $startDate, string $endDate, string $coinId): array
        {
            $result = [];
            $coinIds = $this->getCoinId($coinId);
            foreach ($coinIds as $coinId) {
                $response = $this->historicalData($coinId, $range, $startDate, $endDate);
                $result[$coinId] = array_column($response, 'rate_close', 'time_period_end');
            }
            return $result;
        }

        public function graph(GraphRequest $request): array
        {
            $coinId = Arr::get($request, 'coin_id');

            if (is_null($coinId)) {
                $coinId = 'All';
            }

            $timePeriod = $request->range;
            $endDate = str_replace(' ', 'T', Carbon::now()->toDateTimeString());
            switch ($timePeriod) {
                case TimePeriod::Day:
                    $range = '1HRS';
                    $startDate = str_replace(' ', 'T', Carbon::now()->subDay(1)->toDateTimeString());
                    return $this->graphData($range, $startDate, $endDate, $coinId);

                case TimePeriod::Weekly:
                    $range = '1DAY';
                    $startDate = str_replace(' ', 'T', Carbon::now()->subDay(6)->toDateTimeString());
                    return $this->graphData($range, $startDate, $endDate, $coinId);

                case TimePeriod::Monthly:
                    $range = '7DAY';
                    $startDate = str_replace(' ', 'T', Carbon::now()->subMonth(1)->toDateTimeString());
                    return $this->graphData($range, $startDate, $endDate, $coinId);

                case TimePeriod::Yearly:
                    $range = '7DAY';
                    $startDate = str_replace(' ', 'T', Carbon::now()->subYear(1)->toDateTimeString());
                    $response = $this->graphData($range, $startDate, $endDate, $coinId);
                    $result = [];
                    $newCoinData = [];

                    foreach ($response as $coinId => $coinData) {
                        foreach ($coinData as $date => $price) {
                            array_push($newCoinData, [
                                'date' => Carbon::parse($date)->format('Y-m'),
                                'price' => $price
                            ]);
                        }
                        $dates = array_unique(array_column($newCoinData, 'date'));

                        $finalResult = [];
                        foreach ($dates as $date) {
                            $count = 0;
                            $sum = 0;
                            foreach ($newCoinData as $response) {
                                if ($response['date'] == $date) {
                                    $count++;
                                    $sum += $response['price'];
                                }
                            }
                            $avg = $sum / $count;
                            $finalResult[$date] = $avg;
                        }
                        $result[$coinId] = $finalResult;
                    }
                    return $result;
                default:
                    $range = '1HRS';
                    $startDate = str_replace(' ', 'T', Carbon::now()->subDay(1)->toDateTimeString());
                    return $this->graphData($range, $startDate, $endDate, $coinId);
            }
        }

        public function recoveryKeys()
        {
            return $this->hasMany(RecoveryKey::class, 'user_id', 'id');
        }

        public function signup()
        {
            return $this->hasOne(Signup::class);
        }

        public function updateProfile(UpdateProfileRequest $request)
        {
            $this->update($request->all());

            if ($request->primary_currency || $request->secondary_currency) {
                $this->setting->update($request->all());
            }
        }


        public function totalDefault()
        {
            $walletBalanceInUSD = $this->wallets()->sum('balance');
            $baseUrl = config('coin.coin.api_url');
            $exchangeURL = $baseUrl . config('coin.coin.usd_to_btc');
            try {
                $usdToBtC = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($exchangeURL)['rate'];
            } catch (\Throwable $th) {

                throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
            }

            return $usdToBtC * $walletBalanceInUSD;
        }

        public function totalPrimaryCurrency(): array
        {
            $primaryCurrency = $this->setting->primary_currency;
            $baseUrl = config('coin.coin.api_url');
            $currencyURL = $baseUrl . config('coin.coin.primary_currency');
            $currency = str_replace('{id}', $primaryCurrency, $currencyURL);

            try {
                $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($currency)['rate'];
            } catch (\Throwable $th) {

                throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
            }

            $balanceInUsd = $this->wallets
                ->mapToGroups(function ($wallet) {
                    return ['balance' => $wallet->balance];
                })
                ->map(function ($e) {
                    return $e->sum();
                });
            return [
                'coin_name' => $primaryCurrency,
                'balance'  => $response * $balanceInUsd['balance'],
            ];
        }

        public function topPerformer(): array
        {
            $coins = $this->userAcceptedCoins();
            $baseUrl = config('coin.coin.api_url');
            $currencyURL = $baseUrl . config('coin.coin.crypto_to_usd');
            $topPerformerBal = PHP_INT_MIN;
            $coinName = null;
            $shortName = null;
            foreach ($coins as $coin) {
                $currency = str_replace('{id}', $coin->coin_id, $currencyURL);
                try {
                    $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($currency);
                    if ($response['rate'] > $topPerformerBal) {
                        $topPerformerBal = $response['rate'];
                        $shortName = $response['asset_id_base'];
                        $coinName  = $coin->name;
                    }
                } catch (\Throwable $th) {

                    throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
                }
            }
            return [
                'balance' => $topPerformerBal,
                'coin_name' => $coinName,
                'coin_id' =>  $shortName
            ];
        }

        public function lowPerformer(): array
        {
            $coins = $this->userAcceptedCoins();

            $baseUrl = config('coin.coin.api_url');
            $currencyURL = $baseUrl . config('coin.coin.crypto_to_usd');
            $lowPerformerBal = PHP_INT_MAX;
            $coinName = null;
            $shortName = null;
            foreach ($coins as $coin) {
                $currency = str_replace('{id}', $coin->coin_id, $currencyURL);
                try {
                    $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($currency);
                    if ($response['rate'] < $lowPerformerBal) {
                        $lowPerformerBal = $response['rate'];
                        $shortName = $response['asset_id_base'];
                        $coinName  = $coin->name;
                    }
                } catch (\Throwable $th) {

                    throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
                }
            }
            return [
                'balance' => $lowPerformerBal,
                'coin_name' => $coinName,
                'coin_id' => $shortName
            ];
        }

        public function wallets()
        {
            return $this->hasMany(Wallet::class, 'user_id', 'id');
        }

        public function setting()
        {
            return $this->hasOne(Setting::class, 'user_id', 'id');
        }

        public function userAcceptedCoins()
        {
            return $this->wallets->map(function ($wallet) {
                return $wallet->coin;
            });
        }
}