<?php

namespace Botble\Domain\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DomainRequest extends Request
{
    public function rules(): array
    {
        $networks = json_decode(setting('admanager_networks'), true);

        $formatted = collect($networks)
            ->flatten(1)
            ->map(function ($network) {
                if($network['key'] == 'code')
                {
                    return $network['value'];
                }
            })
            ->filter()
            ->toArray();

        return [
            'name' => ['required', 'string', 'max:220'],
            'network_code' => ['required', 'integer', Rule::in(array_values($formatted))],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
