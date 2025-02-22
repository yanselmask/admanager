<?php

namespace Botble\Domain\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\FormAbstract;
use Botble\Domain\Http\Requests\DomainRequest;
use Botble\Domain\Models\Domain;
use Botble\Member\Models\Member;

class DomainForm extends FormAbstract
{
    public function setup(): void
    {
        $networks = json_decode(setting('admanager_networks'), true);

        $formatted = collect($networks)
            ->mapWithKeys(function ($items) {
                $pair = [];
                foreach ($items as $item) {
                    if ($item['key'] == 'code') {
                        $pair['code'] = $item['value'];
                    }
                    if ($item['key'] == 'name') {
                        $pair['name'] = $item['value'];
                    }
                }
                return isset($pair['code'], $pair['name']) ? [$pair['code'] => $pair['name']] : [];
            })
            ->toArray();


        $this
            ->model(Domain::class)
            ->setValidatorClass(DomainRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('url', TextField::class, TextFieldOption::make()->required())
            ->add('is_subdomain', OnOffField::class, OnOffFieldOption::make()->label(__('Subdomain')))
            ->add('commissions', TextField::class, TextFieldOption::make()->helperText(__('Esta es la comisión que te tocará de este sitio web.')))
            ->add('commissions_network', TextField::class, TextFieldOption::make()->helperText(__('Esta es la comisión que le tocara a la network')))
            ->add('commissions_webmaster', TextField::class, TextFieldOption::make()->helperText(__('Esta es la comisión que le tocara al promotor')))
            ->add('member_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Author'))
                    ->choices(is_plugin_active('member') ? Member::query()->pluck('first_name', 'id')->toArray() : [])
                    ->searchable()
                )
            ->add('network_code',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Network Code'))
                    ->choices($formatted)
                    ->searchable()
                    ->required()
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
