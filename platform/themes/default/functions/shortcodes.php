<?php

use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Member\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Theme\Facades\Theme;
use Botble\Base\Forms\Fields;
use Botble\Base\Forms\FieldOptions;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();
    Shortcode::register(
        'saas_banner',
        __('Saas Banner'),
        __('Saas Banner'),
        function (ShortcodeCompiler $shortcode) {
            $brands = collect();
            $brandsIds = Shortcode::fields()->getIds('brands_ids', $shortcode);
            if (is_plugin_active('brands') && $brandsIds) {
                $brands = \Botble\Brands\Models\Brands::query()
                    ->wherePublished()
                    ->whereIn('id', $brandsIds)
                    ->select([
                        'id',
                        'name',
                        'link',
                        'image_url',
                    ])
                    ->get();
            }

            return Theme::partial('shortcodes.saas_banner', compact('shortcode','brands'));
        }
    );
    Shortcode::register(
        'saas_feature',
        __('Saas Feature'),
        __('Saas Feature'),
        function (ShortcodeCompiler $shortcode) {
            $tabs = Shortcode::fields()->getTabsData(['direction','subtitle','title', 'description','color', 'image', 'features','button_text','button_link'], $shortcode);
            return Theme::partial('shortcodes.saas_feature', compact('shortcode','tabs'));
        }
    );
    Shortcode::register(
        'saas_about_area',
        __('Saas About Area'),
        __('Saas About Area'),
        function (ShortcodeCompiler $shortcode) {
            $skills = Shortcode::fields()->getTabsData(['title','subtitle'], $shortcode);
            return Theme::partial('shortcodes.saas_about_area', compact('shortcode','skills'));
        }
    );
    Shortcode::register(
        'promo_area_three',
        __('Promo Area'),
        __('Promo Area'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.promo_area_three', compact('shortcode'));
        }
    );
    Shortcode::register(
        'service_category_area',
        __('Service Area'),
        __('Service Area'),
        function (ShortcodeCompiler $shortcode) {
            $services = Shortcode::fields()->getTabsData(['title','description', 'icon'], $shortcode);
            return Theme::partial('shortcodes.service_category_area', compact('shortcode','services'));
        }
    );
    Shortcode::register(
        'saas_faq_area',
        __('Saas Faq Area'),
        __('Saas Faq Area'),
        function (ShortcodeCompiler $shortcode) {
            $faqs = Shortcode::fields()->getTabsData(['title','description','opened'], $shortcode);
            return Theme::partial('shortcodes.saas_faq_area', compact('shortcode','faqs'));
        }
    );
    Shortcode::setAdminConfig('saas_banner', function (array $attributes) {

        $brands = [];
        $brandsIds = [];
        if(is_plugin_active('brands'))
        {
            $brands = \Botble\Brands\Models\Brands::query()->wherePublished()->pluck('name', 'id')->all();
            $brandsIds = \Illuminate\Support\Arr::get($attributes, 'brands_ids');

            if (! is_array($brandsIds)) {
                $brandsIds = $brandsIds ? explode(',', $brandsIds) : null;
            }
        }
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'youtube_link',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Youtube Link'))
            )
            ->add(
                'youtube_image',
                Fields\MediaImageField::class,
                FieldOptions\MediaImageFieldOption::make()->label(__('Youtube Image'))
            )
            ->add(
                'title',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Title'))
            )
            ->add(
                'description',
                Fields\TextareaField::class,
                FieldOptions\TextareaFieldOption::make()->label(__('Description'))
            )
            ->add(
                'button_text',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Button Text'))
            )
            ->add(
                'button_link',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Button Link'))->defaultValue('#')
            )
            ->add(
                'description_footer',
                Fields\TextareaField::class,
                FieldOptions\TextareaFieldOption::make()->label(__('Description Footer'))
            )
            ->add(
                'brands_ids',
                Fields\SelectField::class,
                     FieldOptions\SelectFieldOption::make()
                    ->label(__('Choose brands'))
                    ->choices($brands)
                    ->selected($brandsIds)
                    ->searchable()
                    ->multiple()
            );
    });
    Shortcode::setAdminConfig('saas_feature', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Title'))
            )
            ->add(
                'subtitle',
                Fields\TextareaField::class,
             FieldOptions\TextareaFieldOption::make()->label(__('Subtitle'))
            )
            ->add(
                'features',
                \Botble\Shortcode\Forms\Fields\ShortcodeTabsField::class,
                \Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption::make()
                    ->fields([
                        'direction' => [
                            'type' => 'select',
                            'options' => [
                                'left' => __('Left'),
                                'right' => __('Right'),
                            ],
                            'title' => __('Direction'),
                            'required' => false,
                        ],
                        'subtitle' => [
                            'type' => 'text',
                            'title' => __('Subtitle'),
                            'required' => false,
                        ],
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                            'required' => false,
                        ],
                        'image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => false,
                        ],
                        'color' => [
                            'type' => 'color',
                            'title' => __('Color'),
                            'required' => false,
                        ],
                        'features' => [
                            'type' => 'textarea',
                            'title' => __('Features'),
                            'required' => false,
                            'helper' => __('Separe feature for comma')
                        ],
                        'button_text' => [
                            'type' => 'text',
                            'title' => __('Button Text'),
                            'required' => false,
                        ],
                        'button_link' => [
                            'type' => 'text',
                            'title' => __('Button Link'),
                            'required' => false,
                        ],
                    ])
                    ->attrs($attributes)
                    ->max(3)
            );
    });
    Shortcode::setAdminConfig('saas_about_area', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'image',
                Fields\MediaImageField::class,
                FieldOptions\MediaImageFieldOption::make()->label(__('Image'))
            )
            ->add(
                'title',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Title'))
            )
            ->add(
                'description',
                Fields\TextareaField::class,
                FieldOptions\TextareaFieldOption::make()->label(__('Subtitle'))
            )
            ->add(
                'button_text',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Button Text'))
            )
            ->add(
                'button_link',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Button Link'))
            )
            ->add('skills',
                \Botble\Shortcode\Forms\Fields\ShortcodeTabsField::class,
                \Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption::make()
                ->fields([
                    'title' => [
                        'type' => 'text',
                        'title' => __('Title'),
                        'required' => false,
                    ],
                    'subtitle' => [
                        'type' => 'text',
                        'title' => __('SubTitle'),
                        'required' => false,
                    ],
                ])
                    ->attrs($attributes)
                    ->max(3)
            );
    });
    Shortcode::setAdminConfig('promo_area_three', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Title'))
            )
            ->add(
                'description',
                Fields\TextareaField::class,
                FieldOptions\TextareaFieldOption::make()->label(__('Subtitle'))
            )
            ->add(
                'button_text',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Button Text'))
            )
            ->add(
                'button_link',
                Fields\TextField::class,
                TextFieldOption::make()->label(__('Button Link'))
            );
    });
    Shortcode::setAdminConfig('service_category_area', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add('faqs',
                \Botble\Shortcode\Forms\Fields\ShortcodeTabsField::class,
                \Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption::make()
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => false,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                            'required' => false,
                        ],
                        'icon' => [
                            'type' => 'image',
                            'title' => __('Icon'),
                            'required' => false,
                        ],
                    ])
                    ->attrs($attributes)
                    ->max(9)
            );
    });
    Shortcode::setAdminConfig('saas_faq_area', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add('style',Fields\SelectField::class, FieldOptions\SelectFieldOption::make()->choices([
                'style1' => __('Style 1'),
                'style2' => __('Style 2'),
            ]))
            ->add('color',Fields\ColorField::class,FieldOptions\ColorFieldOption::make()->label(__('Color'))->defaultValue('#F8F9FC'))
            ->add('title',Fields\TextField::class,FieldOptions\TextFieldOption::make()->label(__('Title')))
            ->add('description',Fields\TextareaField::class,FieldOptions\TextareaFieldOption::make()->label(__('Description')))
            ->add('faqs',
                \Botble\Shortcode\Forms\Fields\ShortcodeTabsField::class,
                \Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption::make()
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Question'),
                            'required' => false,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Answer'),
                            'required' => false,
                        ],
                        'opened' => [
                            'type' => 'onOff',
                            'title' => __('Opened'),
                        ]
                    ])
                    ->attrs($attributes)
                    ->max(10)
            );
    });
});
