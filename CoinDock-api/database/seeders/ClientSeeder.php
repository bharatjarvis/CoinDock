<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class ClientSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //creating access token and grant token
        Client::factory()->create([ 
            'id' => 1,
            'name' => 'Laravel Personal Access Client',
            'secret' => 'Ud6HlAvIaZhAvlySkKdC5RQphmb2V1td5SdFRd2O',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 1,
            'revoked' => 0,
        ]);
        
        Client::factory()->create([
            'id' => 2,
            'name' => 'Laravel Password Grant Client',
            'secret' => 'kdgM8fHDFln8epjcuxd2QfiUWmhSkFAlZ9SO4JUh',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'provider' => 'user',
            'revoked' => 0,
        ]);
    }
}