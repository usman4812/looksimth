<head>
    <title>{{ @$data['title'] }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="{{ @$data['meta_desc'] }}" />
    <meta name="keywords" content="{{ @$data['keyword'] }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ @$data['title'] }}" />
    <meta property="og:url" content="{{ route('admin.dashboard') }}" />
    <meta property="og:site_name" content="EH Meals" />
    <link rel="shortcut icon" href="{{ asset('admin_assets/logos/locksmith.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('admin_assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin_assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin_assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/style.bundle.css?v=1.6') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .productsDiv .select2-container {
            display: none !important;

        }

        .select2-container .select2-selection--single {
            height: 100% !important;
        }

        .select2-selection__rendered {
            white-space: break-spaces !important;
        }
    </style>
    @stack('style')
</head>
