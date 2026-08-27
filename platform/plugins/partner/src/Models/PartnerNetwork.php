<?php

namespace Botble\Partner\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;
use Botble\Partner\Supports\AdmanagerNetworks;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartnerNetwork extends BaseModel
{
    protected $table = 'partner_networks';

    protected $fillable = [
        'member_id',
        'network_code',
        'commission',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'commission' => 'float',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class, 'network_code', 'network_code');
    }

    /**
     * Nombre legible de la network, tomado del setting `admanager_networks`.
     */
    public function getNetworkNameAttribute(): string
    {
        return AdmanagerNetworks::name((string) $this->network_code);
    }
}
