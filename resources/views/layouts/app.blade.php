<!DOCTYPE html>
<html lang="ar" dir="rtl">
    
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'منصة تدوين')</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap RTL من CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body { background: #f1eef0;  padding-top:60px; margin-right: -150px;}
        .navbar { margin-bottom: 10px; }
    </style>
</head>

<body>
    
    @include('layouts.navbar')
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>