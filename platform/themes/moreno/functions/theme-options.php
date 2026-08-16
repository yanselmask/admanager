<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('PAGO Social primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#004AAD',
            ],
        ]);
});
