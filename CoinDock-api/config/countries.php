<?php

return [
    'countries'=>['India','Canada','Japan','Germany','Pakistan','Switzerland','Australia','United States','New Zealand','United Kingdom','Sweden','Netherlands','France','Denmark','Norway','Singapore','South Korea','Italy','China','Finaland','Spain','Belgium','Austria','United Arab Emirates','Ireland','Russia','Brazil','Greece','Thailand','Portugal','Israel','South Africa','Mexico','Qatar','Egypt','Turkey','Saudi Arabia','Malaysia','Indonesia','Morocco','Costa Rica','Vietnam','Argentina','Poland','Philippines','Czechia','Croatia','Sri Lanka','Hungary','Chile','Peru'],

    'default_country'=>[
        'name'=>env('COUNTRY_NAME'),
        'code'=>env('COUNTRY_CODE'),
        'currency'=>env('COUNTRY_CURRENCY')
    ]
];