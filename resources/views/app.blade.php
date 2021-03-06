<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" sizes="192x192" href="icon.ico">
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Norican&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <style>
            .post {
                position: relative;
                flex: 1 0 220px;
                color: #fff;
                cursor: pointer;
                height:280px;
            }
            .post:hover .post-info,
            .post:focus .post-info {
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.3);
            }
            .post-info {
                display: none;
            }
            .rtl{
                direction: rtl;
            }
            .ltr{
                direction: ltr;
            }
        </style>
        <!-- Scripts -->
        @routes
        <script src="https://kit.fontawesome.com/256efe1232.js" crossorigin="anonymous"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        
        
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
