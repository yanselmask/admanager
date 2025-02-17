<?php

namespace Botble\Brands\Forms;

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Brands\Http\Requests\BrandsRequest;
use Botble\Brands\Models\Brands;

class BrandsForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Brands::class)
            ->setValidatorClass(BrandsRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('link', TextField::class, TextFieldOption::make()->defaultValue('#'))
            ->add('image_url', MediaImageField::class, MediaImageFieldOption::make()->label(__('Logo')))
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
