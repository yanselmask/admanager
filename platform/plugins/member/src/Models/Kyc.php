<?php

namespace Botble\Member\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Member\Enums\KycStatus;

class Kyc extends BaseModel
{
    protected $table = 'kycs';

    protected $fillable = [
        'name',
        'last_name',
        'address',
        'nationality',
        'document_type',
        'document_number',
        'document_front',
        'document_back',
        'selfie',
        'status',
    ];

    protected $casts = [
        'status' => KycStatus::class,
        'name' => SafeContent::class,
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
