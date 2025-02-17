<?php

namespace Botble\Admanager\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AdmanagerRequest extends Request
{
    public function rules(): array
    {
        return [
            'admanager_network_code' => ['required', 'string'],
            'admanager_network_name' => ['nullable', 'string'],
            'admanager_json' => ['required'],
            'percentage_default' => ['required', 'integer','min:0', 'max:100'],
            'week_start' => ['nullable', 'integer', 'min:0', 'max:6'],
        ];
    }
}
