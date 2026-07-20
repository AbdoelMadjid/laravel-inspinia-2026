<!doctype html>
<html lang="en" class="@yield('html_class')" @yield('html_attributes')>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title', 'INSPINIA')</title>
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

        @stack('styles')
    </head>

    <body>
        @yield('content')

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        @stack('scripts')
    </body>
</html>
