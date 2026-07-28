<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin Dashboard | Nicole Murray</title>

    {{-- Favicon Icon --}}
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">
    {{-- Plugin CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style">
    {{-- Icons CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/icons.min.css') }}">
    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style">
    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    {{-- Responsive DataTable CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
    {{-- Tagify CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    {{-- ✅ Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Summernote CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    {{-- jQuery CDN --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <style>
        .dt-buttons.btn-group.flex-wrap {
            display: none;
        }

        .custom_status_badge {
            font-size: 15px;
            padding: 10px 15px;
        }
    </style>

</head>

<body>

    <div id="layout-wrapper">

        {{-- Header Area --}}
        @include('admin.layout.header')

        {{-- Sidebar Area --}}
        @include('admin.layout.sidebar')

        <div class="main-content">

            {{-- Index Area --}}
            @yield('admin')

            {{-- Footer Area --}}
            @include('admin.layout.footer')

        </div>

    </div>

    {{-- Right Sidebar Area --}}
    @include('admin.layout.right_sidebar')

    {{-- Right Bar Overlay --}}
    <div class="rightbar-overlay"></div>


    {{-- Vendor JS --}}
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/pass-addon.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- DataTables --}}
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>
    {{-- Summernote --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    {{-- FontAwesome --}}
    <script src="{{ asset('backend/assets/js/pages/fontawesome.init.js') }}"></script>
    {{-- Tagify JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    {{-- ✅ Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Custom Scripts --}}
    @include('admin.layout.custom_scripts')

</body>

</html>
