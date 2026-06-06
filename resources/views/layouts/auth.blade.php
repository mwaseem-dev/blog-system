<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog System')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100">
    @yield('content')
</body>
</html>
