<?php

namespace Database\Seeders;

use App\Models\V1\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //creating access token and grant token
       $this->call(ClientSeeder::class);
        
        User::factory(10)->create();

    }
}