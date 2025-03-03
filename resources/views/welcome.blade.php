<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rugby Game</title>

    <!-- Vite directive for CSS -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    <div id="app">
        <!-- Vue components will render here based on the router -->
        <router-view></router-view>
    </div>
</body>

</html>
