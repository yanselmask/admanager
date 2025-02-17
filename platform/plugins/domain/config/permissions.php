<?php

return [
    [
        'name' => 'Domains',
        'flag' => 'domain.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'domain.create',
        'parent_flag' => 'domain.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'domain.edit',
        'parent_flag' => 'domain.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'domain.destroy',
        'parent_flag' => 'domain.index',
    ],
];
