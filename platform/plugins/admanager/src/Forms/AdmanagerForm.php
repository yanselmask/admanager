<?php

namespace Botble\Admanager\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Admanager\Http\Requests\AdmanagerRequest;
use Botble\Admanager\Models\Admanager;

class AdmanagerForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Admanager::class)
            ->setValidatorClass(AdmanagerRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
