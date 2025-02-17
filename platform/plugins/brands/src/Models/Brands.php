<?php

namespace Botble\Brands\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Brands extends BaseModel
{
    protected $table = 'brands';

    protected $fillable = [
        'name',
        'link',
        'image_url',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];
}
