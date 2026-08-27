<?php

namespace Botble\Partner\Forms;

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Member\Models\Member;
use Botble\Partner\Enums\PartnerRoleEnum;
use Botble\Partner\Http\Requests\PartnerRequest;

class PartnerForm extends FormAbstract
{
    public function setup(): void
    {
        $model = $this->getModel();
        $isExisting = $model instanceof Member && $model->getKey();

        $this
            ->model(Member::class)
            ->setValidatorClass(PartnerRequest::class)
            ->add(
                'member_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/partner::partner.member'))
                    ->choices($this->memberChoices($isExisting ? $model : null))
                    ->selected($isExisting ? $model->getKey() : null)
                    ->searchable()
                    ->required()
                    ->disabled($isExisting)
                    ->helperText(trans('plugins/partner::partner.member_helper'))
            )
            ->add(
                'role',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/partner::partner.role'))
                    ->choices(PartnerRoleEnum::labels())
                    ->selected($isExisting ? $model->getAttribute('role') : PartnerRoleEnum::PARTNER)
                    ->required()
                    ->helperText(trans('plugins/partner::partner.role_helper'))
            )
            ->add(
                'commission',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/partner::partner.networks.commission'))
                    ->value($isExisting ? $model->getAttribute('commission') : null)
                    ->helperText(trans('plugins/partner::partner.commission_helper', [
                        'value' => (float) setting('partner_percentage_default', 0),
                    ]))
            );
    }

    /**
     * Al crear se ofrecen los miembros que aún no son partner; al editar, solo el actual,
     * porque el partner se identifica con el propio miembro y cambiarlo sería otro registro.
     *
     * @return array<int, string>
     */
    protected function memberChoices(?Member $current): array
    {
        if ($current) {
            return [$current->getKey() => $current->name.' ('.$current->email.')'];
        }

        return Member::query()
            ->where('role', '!=', PartnerRoleEnum::PARTNER)
            ->orWhereNull('role')
            ->get(['id', 'first_name', 'last_name', 'email'])
            ->mapWithKeys(fn (Member $member) => [
                $member->getKey() => $member->name.' ('.$member->email.')',
            ])
            ->all();
    }
}
