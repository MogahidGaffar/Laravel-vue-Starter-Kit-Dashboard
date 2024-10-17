<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title > {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Favicons -->
    <link href="{{ asset('dashboard-assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('dashboard-assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">


    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('dashboard-assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('dashboard-assets/css/style.css') }}" rel="stylesheet">

    @if (app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('dashboard-assets/css/style-ltr.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    @else
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/style-rtl.css') }}">
    @endif
   
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
 {{-- Copyright (c) 2024 @MogahidGaffar --}}

    @inertia


   

    <!-- Vendor JS Files -->
    <script src="{{ asset('dashboard-assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('dashboard-assets/js/main.js') }}"></script>


</body>

</html>
