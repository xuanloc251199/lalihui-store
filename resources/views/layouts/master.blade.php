<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Lalihui</title>
    <link rel="stylesheet preload" as="style" href="{{asset('assets/css/preload.min.css')}}" />
    <link rel="stylesheet preload" as="style" href="{{asset('assets/css/libs.min.css')}}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    @yield('header')
    
    @yield('page-header')

    <main>
        @yield('content')
    </main>

    @yield('footer')
</body>
</html>
