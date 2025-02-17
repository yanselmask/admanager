<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id' => 'preloader_swift',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'onOff',
            'label' => __('Enable Preloader'),
            'attributes' => [
                'name' => 'preloader_swift',
                'value' => 1,
                'data' => [
                    0 => 'No',
                    1 => 'Yes',
                ],
                'options' => [],// Optional
            ],
            'helper' => __('Here you can enable the prelaoder'),
        ])
        ->setSection([ // Set section with no field
            'title' => __('Header'),
            'desc' => __('Header settings'),
            'id' => 'opt-text-subsection-header',
            'subsection' => true,
            'icon' => 'fa fa-heading',
        ]);
});
