<?php

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Menu\Models\Menu;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class InfoFooterWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Info Footer'),
            'description' => __('Widget description'),
        ]);
    }

    protected function data(): array|Collection
    {
        return [];
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add('logo', \Botble\Base\Forms\Fields\MediaImageField::class, \Botble\Base\Forms\FieldOptions\MediaFileFieldOption::make())
            ->add('content',\Botble\Base\Forms\Fields\TextareaField::class, \Botble\Base\Forms\FieldOptions\TextareaFieldOption::make())
            ->add(
                'menu_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Menu'))
                    ->choices(Menu::query()->pluck('name', 'slug')->all())
                    ->searchable()
            );
    }
}
