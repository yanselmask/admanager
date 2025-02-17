<?php

return [
    [
        'name' => 'Brands',
        'flag' => 'brands.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'brands.create',
        'parent_flag' => 'brands.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'brands.edit',
        'parent_flag' => 'brands.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'brands.destroy',
        'parent_flag' => 'brands.index',
    ],
];
