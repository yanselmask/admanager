<?php

namespace Botble\Domain\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Member\Models\Member;

class Domain extends BaseModel
{
    protected $table = 'domains';

    protected $fillable = [
        'name',
        'url',
        'network_code',
        'commissions',
        'commissions_network',
        'commissions_webmaster',
        'is_subdomain',
        'member_id',
        'impressions',
        'clicks',
        'ctrs',
        'earnings',
        'ecpms',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'impressions' => 'array',
        'clicks' => 'array',
        'ctrs' => 'array',
        'earnings' => 'array',
        'ecpms' => 'array',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function getEarning($column, $com = null)
    {
        $comission = $com ?? ($this->commissions ?? setting('percentage_default'));
        return isset($this->earnings[$column]) ? getValueWithCommissions($this->earnings[$column], $comission, includePercentage: true) : null;
    }

    public function getEarningInverse($column, $com = null)
    {
        return isset($this->earnings[$column]) ? getValueWithCommissionsInverse($this->earnings[$column], $com, includePercentage: true) : null;
    }

    public function getImpressions($column)
    {
        return isset($this->impressions[$column]) ? getValueWithCommissions($this->impressions[$column], $this->commissions ?? setting('percentage_default'), false, includePercentage: setting('include_percentage_in_impressions', false)) : null;
    }

    public function getClicks($column)
    {
        return isset($this->clicks[$column]) ? getValueWithCommissions($this->clicks[$column], $this->commissions ?? setting('percentage_default'), false, round: true, includePercentage: setting('include_percentage_in_clicks', false)) : null;
    }

    public function getCtrs($column)
    {
        return isset($this->ctrs[$column]) ? getValueWithCommissions($this->ctrs[$column], $this->commissions ?? setting('percentage_default'), false, includePercentage: setting('include_percentage_in_ctrs', false)) : null;
    }

    public function getEcpms($column)
    {
        return isset($this->ecpms[$column]) ?
               getValueWithCommissions($this->ecpms[$column], ( $this->commissions ?? setting('percentage_default') ), includePercentage: (bool) setting('include_percentage_in_ecpm', false))
               : null;
    }
}
