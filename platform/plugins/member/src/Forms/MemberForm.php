<?php

namespace Botble\Member\Forms;

use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FieldOptions\DatePickerFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\DatePickerField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Member\Http\Requests\MemberCreateRequest;
use Botble\Member\Models\Member;

class MemberForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScriptsDirectly(['/vendor/core/plugins/member/js/member-admin.js']);


        $this
            ->model(Member::class)
            ->setValidatorClass(MemberCreateRequest::class)
            ->columns()
            ->add(
                'first_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/member::member.first_name'))
                    ->required()
                    ->maxLength(120)
                    ->colspan(1)
            )
            ->add(
                'last_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/member::member.last_name'))
                    ->required()
                    ->maxLength(120)
                    ->colspan(1)
            )
            ->add(
                'email',
                TextField::class,
                EmailFieldOption::make()->required()->colspan(1)
            )
            ->add(
                'username',
                TextField::class,
                TextFieldOption::make()
                    ->colspan(1)
                    ->disabled()
            )
            ->add(
                'ref_by',
                TextField::class,
                TextFieldOption::make()
                    ->value(route('public.member.register') . '?ref_by=' . auth('member')->user()?->username)
                    ->disabled()
            )
            ->add(
                'phone',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/member::member.phone'))
                    ->placeholder(trans('plugins/member::member.phone_placeholder'))
                    ->maxLength(15)
                    ->colspan(1)
            )
            ->add(
                'dob',
                DatePickerField::class,
                DatePickerFieldOption::make()
                    ->label(trans('plugins/member::member.dob'))
                    ->colspan(1)
            )
            ->add('payment_method_default',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('Payment Method'))
                    ->choices([
                        'paypal' => __('Paypal'),
                        'usdt_trc20' => __('USDT TRC20'),
                        'usdt_bep20' => __('USDT BEP20'),
                        'bank' => __('Bank')
                    ])
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()->colspan(2)
            )
            ->add(
                'is_change_password',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/member::member.form.change_password'))
                    ->defaultValue(0)
                    ->colspan(2)
            )
            ->add(
                'password',
                'password',
                TextFieldOption::make()
                    ->label(trans('plugins/member::member.form.password'))
                    ->collapsible('is_change_password', 1, ! $this->getModel()->exists || $this->getModel()->is_change_password)
                    ->required()
                    ->maxLength(60)
                    ->colspan(1)
            )
            ->add(
                'password_confirmation',
                'password',
                TextFieldOption::make()
                    ->label(trans('plugins/member::member.form.password_confirmation'))
                    ->collapsible('is_change_password', 1, ! $this->getModel()->exists || $this->getModel()->is_change_password)
                    ->required()
                    ->maxLength(60)
                    ->colspan(1)
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->add(
                'avatar_image',
                MediaImageField::class,
                MediaImageFieldOption::make()->value($this->getModel()->avatar->url)
            )
            ->setBreakFieldPoint('status');
    }
}
