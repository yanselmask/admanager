<script src="{{asset('custom/amauri/assets/js/config.js')}}"></script>
<script src="{{asset('custom/amauri/vendors/simplebar/simplebar.min.js')}}"></script>

<!-- ===============================================--><!--    Stylesheets--><!-- ===============================================-->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
<link href="{{asset('custom/amauri/vendors/simplebar/simplebar.min.css')}}" rel="stylesheet">
<link href="{{asset('custom/amauri/assets/css/theme-rtl.min.css')}}" rel="stylesheet" id="style-rtl">
<link href="{{asset('custom/amauri/assets/css/theme.min.css')}}" rel="stylesheet" id="style-default">
<link href="{{asset('custom/amauri/assets/css/user-rtl.min.css')}}" rel="stylesheet" id="user-style-rtl">
<link href="{{asset('custom/amauri/assets/css/user.min.css')}}" rel="stylesheet" id="user-style-default">
<link href="{{asset('custom/amauri/toast-magic.css')}}" rel="stylesheet">
<style>
    /* ── Light mode ────────────────────────────────────────────────── */
    :root {
        --falcon-secondary-color: #57606a;
        --falcon-gray-100: #ffffff;
        --falcon-bg-navbar-glass: #f6f8fa;
        --falcon-emphasis-bg: #eaeef2;
        --falcon-tertiary-bg-rgb: #eaeef2;
        --falcon-quaternary-bg: #eaeef2;
        --falcon-body-bg: #f6f8fa;
        --falcon-card-bg: #ffffff;
        --falcon-border-color: #d0d7de;
    }
    [data-bs-theme="light"] body {
        background-color: var(--falcon-body-bg);
    }
    [data-bs-theme="light"] .table th { color: #24292f; }
    [data-bs-theme="light"] .table tr { border-bottom: 1px solid #d0d7de; }

    /* ── Dark mode ─────────────────────────────────────────────────── */
    [data-bs-theme="dark"] {
        --falcon-secondary-color: #c9d1d9;
        --falcon-gray-100: #0d1117;
        --falcon-bg-navbar-glass: #0d1117;
        --falcon-emphasis-bg: #161b22;
        --falcon-tertiary-bg-rgb: #161b22;
        --falcon-quaternary-bg: #161b22;
        --falcon-body-bg: #0d1117;
        --falcon-card-bg: #161b22;
        --falcon-border-color: #30363d;
    }
    [data-bs-theme="dark"] body {
        background-color: var(--falcon-body-bg);
        color: #c9d1d9;
    }
    [data-bs-theme="dark"] .table th { color: #8b949e; }
    [data-bs-theme="dark"] .table tr { border-bottom: 1px solid #30363d; }
</style>
<script>
    var isRTL = JSON.parse(localStorage.getItem('isRTL'));
    if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
</script>
