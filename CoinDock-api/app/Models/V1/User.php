<?php

namespace App\Models\V1;

use App\Enums\V1\UserStatus;
use App\Enums\V1\UserType;
use App\Models\V1\{Coin, Signup};
use App\Http\Requests\V1\CreateUserRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Http;
use App\Models\V1\Wallet;
use App\Models\V1\Setting;

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
        $signup = $this->signUp;
        if ($signup) {
            $signup->step_count += 1;
            $signup->save();
        }

        Signup::create(['step_count' => 1, 'user_id' => $user->id]);

        return $user;
    }

    public function recoveryKeys()
    {
        return $this->hasMany(RecoveryKey::class, 'user_id', 'id');
    }

    public function signUp()
    {
        return $this->hasOne(Signup::class);
    }

    public function totalDefault()
    {
        $walletBalanceInUSD = $this->wallets()->sum('balance');
        $baseUrl = config('coin.coin.api_url');
        $exchangeURL = $baseUrl . config('coin.coin.usd_to_Btc');
        $usdToBtC = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($exchangeURL);
        return $usdToBtC['rate'] * $walletBalanceInUSD;
    }




    public function totalPrimaryCurrency(): array
    {
        $userSetting = $this->settings;
        $primaryCurrency = $userSetting->primary_currency;
        $baseUrl = config('coin.coin.api_url');
        $currencyURL = $baseUrl . config('coin.coin.primary_currency');
        $currency = str_replace('{id}', $primaryCurrency, $currencyURL);
        $primaryBalancePath = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($currency);
        $balanceInUsd = $this->wallets
            ->mapToGroups(function ($wallet) {
                return ['balance' => $wallet->balance];
            })
            ->map(function ($e) {
                return $e->sum();
            });
        return [
            'coin_name' => $primaryCurrency,
            'balance'  => $primaryBalancePath['rate'] * $balanceInUsd['balance']
        ];
    }


    public function topPerformer():array
    {
        $walletCoinIds = $this->wallets()->pluck('coin_id');
        $coins = Coin::select(['coin_id', 'name'])->whereIn('id', $walletCoinIds)->get();
        $baseUrl = config('coin.coin.api_url');
        $currencyURL = $baseUrl . config('coin.coin.top_performer');
        $topPerformerBal = PHP_INT_MIN;
        $coinName = Null;
        $shortName = Null;
        foreach ($coins as $coin) {
            $currency = str_replace('{id}', $coin->coin_id, $currencyURL);
            $primaryBalancePath = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($currency);
            if ($primaryBalancePath['rate'] > $topPerformerBal) {
                $topPerformerBal = $primaryBalancePath['rate'];
                $shortName = $primaryBalancePath['asset_id_base'];
                $coinName  = Coin::whereCoinId($shortName)->first()?->name;
            }
        }
            return[
                'balance' => $topPerformerBal,
                'coin_name' => $coinName,
                'coin_id' =>  $shortName
            ];
    }

    public function lowPerformer(): array
    {
        $walletCoinIds = $this->wallets()->pluck('coin_id');
        $coins = Coin::select(['coin_id', 'name'])->whereIn('id', $walletCoinIds)->get();
            $baseUrl = config('coin.coin.api_url');
            $currencyURL = $baseUrl . config('coin.coin.top_performer');
            $lowPerformerBal = PHP_INT_MAX;
            $coinName = Null;
            $shortName= Null;
            foreach ($coins as $coin) {
                $currency = str_replace('{id}', $coin->coin_id, $currencyURL);
                $primaryBalancePath = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($currency);
                if ($primaryBalancePath['rate'] < $lowPerformerBal) {
                    $lowPerformerBal = $primaryBalancePath['rate'];
                    $shortName= $primaryBalancePath['asset_id_base'];
                    $coinName  = Coin::whereCoinId($shortName)->first()?->name;
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

    public function settings()
    {
        return $this->hasOne(Setting::class, 'user_id', 'id');
    }
}
