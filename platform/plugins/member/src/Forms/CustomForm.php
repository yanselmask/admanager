<?php

namespace Botble\Member\Forms;

use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FieldOptions\DatePickerFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
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

class CustomForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScriptsDirectly(['/vendor/core/plugins/member/js/member-admin.js']);

        $this
            ->model(Member::class)
            ->setUrl(route('public.member.post.customfields'))
            ->setFormOption('template', 'core/base::forms.form-content-only')
            ->template('core/base::forms.form-content-only')
            ->columns()
            ->setBreakFieldPoint('status');
    }
}
