<?php

return [
    'search' => [
        'smart'            => false,
        'case_insensitive' => true,
        'use_wildcards'    => false,
        'regex'            => true,
    ],

    'fractal' => [
        'serializer' => 'League\Fractal\Serializer\DataArraySerializer',
    ],

    'script_template' => 'datatables::script',
];
