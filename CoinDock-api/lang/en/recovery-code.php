<?php

use Illuminate\Support\Facades\Config;

    $supportEmail = Config::get('mail.support_address');
  
    return [
        'attempt-1' => "You're left with only 2 attempts of generating recovery information.",
        'attempt-2' => "You're left with only 1 attempts of generating recovery information.",
        'attempt-3' => 
            "Your account has been locked as you utilized all attempts. Please contact customer support {$supportEmail}",
];
