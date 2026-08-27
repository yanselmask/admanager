<?php

namespace Botble\Partner\Forms;

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Http\Requests\PartnerNetworkRequest;
use Botble\Partner\Models\PartnerNetwork;
use Botble\Partner\Supports\AdmanagerNetworks;

class PartnerNetworkForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(PartnerNetwork::class)
            ->setValidatorClass(PartnerNetworkRequest::class)
            ->add(
                'member_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/partner::partner.member'))
                    ->choices($this->partnerChoices())
                    ->searchable()
                    ->required()
            )
            ->add(
                'network_code',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/partner::partner.networks.network_code'))
                    ->choices(AdmanagerNetworks::all())
                    ->searchable()
                    ->required()
                    ->helperText(trans('plugins/partner::partner.networks.network_code_helper'))
            )
            ->add(
                'commission',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/partner::partner.networks.commission'))
                    ->helperText(trans('plugins/partner::partner.networks.commission_helper'))
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }

    /**
     * @return array<int, string>
     */
    protected function partnerChoices(): array
    {
        return Member::query()
            ->where('role', PartnerRoleEnum::PARTNER)
            ->get(['id', 'first_name', 'last_name', 'email'])
            ->mapWithKeys(fn (Member $member) => [
                $member->getKey() => $member->name.' ('.$member->email.')',
            ])
            ->all();
    }
}
