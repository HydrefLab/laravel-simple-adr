<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Entity - Transformer map
    |--------------------------------------------------------------------------
    |
    | Here you can define which transformer and what resource name should be
    | used for transforming given entity.
    |
    | Transforming mechanism is using Fractal package by PHP League.
    |
    */
    'transformers' => [
        'EntityClass' => [
            'transformer' => 'TransformerClass',
            'resource' => 'ResourceName'
        ],
    ]
];