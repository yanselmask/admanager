<?php

return [
    [
        'name' => 'Admanagers',
        'flag' => 'admanager.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'admanager.create',
        'parent_flag' => 'admanager.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'admanager.edit',
        'parent_flag' => 'admanager.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'admanager.destroy',
        'parent_flag' => 'admanager.index',
    ],
];
