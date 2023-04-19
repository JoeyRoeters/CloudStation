<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="../../../"/>
        <title>CloudStation</title>
        <meta charset="utf-8"/>
        <meta name="description"
              content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free."/>
        <meta name="keywords"
              content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>

        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>

        @vite('resources/css/app.css')
    </head>
    <body id="kt_body" @if(isset($login)) class="app-blank app-blank bg-red-100 bgi-size-cover bgi-position-center bgi-no-repeat"
          @else data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true"
          data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
          data-kt-app-sidebar-push-footer="true" class="app-default" @endif">
        <script>var defaultThemeMode = "light";
            var themeMode;
            if (document.documentElement) {
                if (document.documentElement.hasAttribute("data-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-theme-mode");
                } else {
                    if (localStorage.getItem("data-theme") !== null) {
                        themeMode = localStorage.getItem("data-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }
                }
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                document.documentElement.setAttribute("data-theme", themeMode);
            }</script>

        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            {{ $slot }}
        </div>

        <script>var hostUrl = "{{ env('APP_URL') }}";</script>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
        <script src="https://www.amcharts.com/lib/4/core.js"></script>
        <script src="https://www.amcharts.com/lib/4/maps.js"></script>
        <script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
        <script src="//cdn.amcharts.com/lib/5/index.js"></script>
        <script src="//cdn.amcharts.com/lib/5/map.js"></script>
        <script src="//cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
        <script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

        @stack('footer')
    </body>
</html>
