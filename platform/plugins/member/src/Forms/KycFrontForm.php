<?php

namespace Botble\Member\Forms;

use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Member\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Botble\Member\Http\Requests\KycRequest;
use Botble\Member\Models\Kyc;

class KycFrontForm extends FormAbstract
{
    public function setup(): void
    {
        $fields = json_decode(setting('kyc_fields',[]));

        $dtypes = \Arr::mapWithKeys(\Arr::flatten(json_decode(setting('kyc_documents_types',[])), 2), function($key){
               return [str_replace(' ', '_', strtolower($key->value)) => $key->value];
            });

        $nationalities = \Arr::mapWithKeys(\Arr::flatten(json_decode(setting('kyc_nationalities',[])), 2), function($key){
            return [str_replace(' ', '_', strtolower($key->value)) => $key->value];
        });

        $this
            ->model(Kyc::class)
            ->hasFiles()
            ->setMethod('POST')
            ->setFormOption('template', 'core/base::forms.form-content-only')
            ->setValidatorClass(KycRequest::class)
            ->setUrl(route('public.member.kyc'))
            ->when(in_array('name', $fields), function ($form) {
                $form->add('name', TextField::class, NameFieldOption::make()->required());
            })
            ->when(in_array('last_name', $fields), function ($form) {
                $form->add('last_name', TextField::class, TextFieldOption::make()->label(__('Last name'))->required());
            })
            ->when(in_array('address', $fields), function ($form) {
                $form->add('address', TextareaField::class, TextareaFieldOption::make()->label(__('Address'))->required());
            })
            ->when(in_array('nationality', $fields), function ($form) use($nationalities) {
                $form->add('nationality',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Nationality'))
                        ->choices($nationalities)
                        ->required()
                );
            })
            ->when(in_array('document_type', $fields), function ($form) use($dtypes) {
                $form->add('document_type',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Document type'))
                        ->choices($dtypes)
                        ->required()
                );
            })
            ->when(in_array('document_number', $fields), function ($form) {
                $form->add('document_number', TextField::class, TextFieldOption::make()->label(__('Document Number'))->required());
            })
            ->when(in_array('document_front', $fields), function ($form) {
                $form->add('document_front', MediaImageField::class, MediaImageFieldOption::make()->label(__('Document Front'))->required());
            })
            ->when(in_array('document_back', $fields), function ($form) {
                $form->add('document_back', MediaImageField::class, MediaImageFieldOption::make()->label(__('Document Back'))->required());
            })
            ->when(in_array('selfie', $fields), function ($form) {
                $form->add('selfie', MediaImageField::class, MediaImageFieldOption::make()->label(__('Selfie'))->required());
            })
            ->add(
                'submit',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->view('plugins/member::includes.submit', [
                        'label' => trans('Send form'),
                    ])
            );
    }
}
