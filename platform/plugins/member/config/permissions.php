<?php

return [
    [
        'name' => 'Members',
        'flag' => 'member.index',
        'parent_flag' => 'core.cms',
    ],
    [
        'name' => 'Create',
        'flag' => 'member.create',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'member.edit',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'member.destroy',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Member',
        'flag' => 'member.settings',
        'parent_flag' => 'settings.others',
    ],
    [
        'name' => 'Kycs',
        'flag' => 'kyc.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'kyc.create',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'kyc.edit',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'kyc.destroy',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Invoices',
        'flag' => 'invoice.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'invoice.create',
        'parent_flag' => 'invoice.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'invoice.edit',
        'parent_flag' => 'invoice.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'invoice.destroy',
        'parent_flag' => 'invoice.index',
    ],
];
