<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css']) <!-- For Laravel Vite -->
</head>
<body>
    <div id="app"></div> <!-- Vue app gets mounted here -->
</body>
</html>
