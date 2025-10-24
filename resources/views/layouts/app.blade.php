<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

</head>


<body>
    @include('layouts.navbar')

    <main id="content" class="space-y-[70px] pb-[100px]">
        @yield('content')
        
        
    </main>
    @include('layouts.footer')

</body>

</html>