<!doctype html>
<html lang="en" class="@yield('html_class')" @yield('html_attributes')>
    <head>
        <meta charset="utf-8" />
        <title @hasSection('title_lang') data-lang="@yield('title_lang')" @endif>@yield('title', 'INSPINIA')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Inspinia is the #1 best-selling admin dashboard template on Wrapmarket. Perfect for building CRM, CMS, project management tools, and custom web apps with clean UI, responsive design, and powerful features." />
        <meta name="keywords" content="Inspinia, admin dashboard, Wrapmarket, Wrapbootstrap, HTML template, Bootstrap admin, CRM template, CMS template, responsive admin, web app UI, admin theme, best admin template" />
        <meta name="author" content="WebAppLayers" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
        
        <!-- Theme Config Js -->
        <script src="{{ asset('assets/js/config.js') }}"></script>

        <!-- Vendor css -->
        <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            /* Center all table headers globally across all routes */
            table th,
            .table th,
            table thead th,
            .table thead th {
                text-align: center !important;
                vertical-align: middle !important;
            }

            /* Add vertical borders (garis tegak) to all tables globally */
            table th,
            table td,
            .table th,
            .table td,
            .table > :not(caption) > * > * {
                border-left-width: 1px !important;
                border-right-width: 1px !important;
                border-left-style: solid !important;
                border-right-style: solid !important;
                border-left-color: var(--bs-border-color, #e9ecef) !important;
                border-right-color: var(--bs-border-color, #e9ecef) !important;
            }
        </style>

        @stack('styles')
    </head>

    <body class="@yield('body_class')" @yield('body_attributes')>
        @yield('content')

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        @include('layouts.partials.sweetalert')

        @stack('scripts')
    </body>
</html>
