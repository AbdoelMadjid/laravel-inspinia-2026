<!doctype html>
<html lang="en" class="@yield('html_class')" @yield('html_attributes')>
    <head>
        <meta charset="utf-8" />
        <title @hasSection('title_lang') data-lang="@yield('title_lang')" @endif>@yield('title', 'INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Inspinia is the #1 best-selling admin dashboard template on Wrapmarket. Perfect for building CRM, CMS, project management tools, and custom web apps with clean UI, responsive design, and powerful features." />
        <meta name="keywords" content="Inspinia, admin dashboard, Wrapmarket, Wrapbootstrap, HTML template, Bootstrap admin, CRM template, CMS template, responsive admin, web app UI, admin theme, best admin template" />
        <meta name="author" content="WebAppLayers" />

        @php $appProfile = \App\Models\Admin\System\AppProfile::get(); @endphp
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ $appProfile->favicon_url }}" />
        
        <!-- Theme Config Js -->
        <script src="{{ asset('assets/js/config.js') }}"></script>

        <!-- Vendor css -->
        <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

        @stack('styles')
    </head>

    <body class="@yield('body_class')" @yield('body_attributes')>
        <!-- Begin page -->
        <div class="wrapper">
            @include('layouts.partials.topbar')

            @include('layouts.partials.search-modal')

            @include('layouts.partials.sidebar')

            <div class="content-page">
                @yield('content')
                {{ $slot ?? '' }}

                @include('layouts.partials.footer')
            </div>
        </div>

        @include('layouts.partials.customizer')

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

        <script>
            window.langPath = "{{ asset('assets/data/translations') }}/";
        </script>
        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        @include('layouts.partials.sweetalert')

        @stack('scripts')
    </body>
</html>
