<?php

namespace Database\Seeders;

use App\Models\V1\OauthClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        OauthClient::factory()->count(1)->create();
    }
}
