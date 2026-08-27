<?php

return [
    [
        'name' => 'Partners',
        'flag' => 'partner.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'partner.create',
        'parent_flag' => 'partner.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'partner.edit',
        'parent_flag' => 'partner.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'partner.destroy',
        'parent_flag' => 'partner.index',
    ],
    [
        'name' => 'Settings',
        'flag' => 'partner.settings',
        'parent_flag' => 'partner.index',
    ],
];
