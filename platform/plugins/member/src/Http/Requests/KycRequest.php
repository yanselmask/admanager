<?php

namespace Botble\Member\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Rules\MediaImageRule;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class KycRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'document_type' => ['nullable', 'string', 'max:255'],
            'document_number' => ['nullable', 'string', 'max:255'],
            'document_front' => ['nullable','string', new MediaImageRule()],
            'document_back' => ['nullable','string', new MediaImageRule()],
            'selfie' => ['nullable','string', new MediaImageRule()],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
