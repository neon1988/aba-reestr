<?php

// config for Altwaireb/World
return [
    'insert_activations_only' => false,
    'countries' => [
        'activation' => [
            'default' => true,
            'only' => [
                'iso2' => [],
                'iso3' => [],
            ],
            'except' => [
                'iso2' => [],
                'iso3' => [],
            ],
        ],
        'chunk_length' => 50,
    ]
];
