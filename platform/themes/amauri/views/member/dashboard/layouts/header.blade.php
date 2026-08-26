{{--{!! SeoHelper::render() !!}--}}
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
<link href="{{asset('custom/amauri/toast-magic.css')}}" rel="stylesheet" id="user-style-default">
<style>
    :root {
        /* Variables por defecto (light mode) */
        --falcon-secondary-color: #FFFFFF;
        --falcon-gray-100: #FFFFFF;
        --falcon-bg-navbar-glass: #FFFFFF;
        --falcon-emphasis-bg: #F5F7FA;
        --falcon-tertiary-bg-rgb: #F5F7FA;
        --falcon-quaternary-bg: #F5F7FA;
        --falcon-body-bg: #FFFFFF;

        .card-dash {
            background-color: #2065C6;
        }
        .table th {
            color: #333;
        }
        .table tr {
            border-bottom: 1px solid #ccc;
        }
    }

    /* Estilos light mode */
    [data-bs-theme="light"] {
        body {
            background-color: var(--falcon-body-bg);
        }
    }

    /* Estilos dark mode */
    [data-bs-theme="dark"] {
        --falcon-secondary-color: #FFFFFF;
        --falcon-gray-100: #000E27;
        --falcon-bg-navbar-glass: #000E27;
        --falcon-emphasis-bg: #011635;
        --falcon-tertiary-bg-rgb: #011635;
        --falcon-quaternary-bg: #011635;
        --falcon-body-bg: #000E27;

        body {
            background-color: var(--falcon-body-bg);
            color: #fff;
        }
        .table th {
            color: #7f99b7;
        }
        .table tr {
            border-bottom: 1px solid #7f99b7;
        }
    }
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
