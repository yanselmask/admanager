<style>
    [v-cloak],
    [x-cloak] {
        display: none;
    }
</style>

{!! BaseHelper::googleFonts('https://fonts.googleapis.com/' . sprintf(
        'css2?family=%s:wght@300;400;500;600;700&display=swap',
        urlencode(theme_option('primary_font', 'Inter')),
)) !!}

<style>
    :root {
        --primary-font: "{{ theme_option('primary_font', 'Inter') }}";
        --primary-color: {{ $primaryColor = theme_option('primary_color', '#004AAD') }};
        --primary-color-rgb: {{ implode(', ', BaseHelper::hexToRgb($primaryColor)) }};
        --secondary-color: {{ $secondaryColor = '#6c7a91' }};
        --secondary-color-rgb: {{ implode(', ', BaseHelper::hexToRgb($secondaryColor)) }};
        --heading-color: inherit;
        --text-color: {{ $textColor = '#182433' }};
        --text-color-rgb: {{ implode(', ', BaseHelper::hexToRgb($textColor)) }};
        --link-color: {{ $linkColor = '#004AAD' }};
        --link-color-rgb: {{ implode(', ', BaseHelper::hexToRgb($linkColor)) }};
        --link-hover-color: {{ $linkHoverColor = '#004AAD' }};
        --link-hover-color-rgb: {{ implode(', ', BaseHelper::hexToRgb($linkHoverColor)) }};
    }
</style>

{!! Assets::renderHeader(['core']) !!}
