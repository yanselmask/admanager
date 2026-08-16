(function () {
    'use strict';

    var themeKey = 'moreno-theme';
    var root = document.documentElement;

    function preferredTheme() {
        var storedTheme = window.localStorage.getItem(themeKey);

        if (storedTheme === 'light' || storedTheme === 'dark') {
            return storedTheme;
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function applyTheme(theme) {
        root.setAttribute('data-theme', theme);
        root.style.colorScheme = theme;
        window.localStorage.setItem(themeKey, theme);

        document.querySelectorAll('[data-moreno-theme-toggle]').forEach(function (toggle) {
            toggle.setAttribute('aria-label', theme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
            toggle.setAttribute('title', theme === 'dark' ? 'Modo claro' : 'Modo oscuro');
            toggle.textContent = theme === 'dark' ? '☼' : '◐';
        });
    }

    applyTheme(preferredTheme());

    document.addEventListener('click', function (event) {
        var toggle = event.target.closest('[data-moreno-theme-toggle]');

        if (!toggle) {
            return;
        }

        applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
})();
