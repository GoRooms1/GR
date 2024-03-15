<?php

return [

    /*
    |--------------------------------------------------------------------------
    | laravel-dadata
    |--------------------------------------------------------------------------
    |
    */
    'token' => env('DADATA_TOKEN', 'a35c9ab8625a02df0c3cab85b0bc2e9c0ea27ba4'),

    'secret' => env('DADATA_SECRET', '205009dec695bf195823041a0d4bd4397368503d'),

    'iplocate_url' =>env('DADATA_IPLOCATE_URL', 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address'),

    'suggest_url' =>env('DADATA_SUGGEST_URL', 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address'),

];
