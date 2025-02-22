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
            'admanager_networks' => ['required'],
            'admanager_json' => ['required'],
            'support_number' => 'nullable',
            'support_message' => 'nullable',
            'percentage_default' => ['required', 'integer','min:0', 'max:100'],
            'referral_commissions' => ['required', 'integer','min:0', 'max:100'],
            'week_start' => ['nullable', 'integer', 'min:0', 'max:6'],
            'earning_member' => ['nullable','array'],
            'impressions_member' => 'nullable',
            'clicks_member' => 'nullable',
            'ctrs_member' => 'nullable',
            'ecpms_member' => 'nullable',
            'member_kyc_is_required' => 'nullable',
            'kyc_fields' => 'nullable',
            'kyc_nationalities' => 'nullable',
            'kyc_documents_types' => 'nullable',
            'invoice_prefix' => 'nullable',
            'invoices_currencies' => 'nullable'
        ];
    }
}
