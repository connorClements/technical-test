<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- Import tailwind --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div class="content">
        <div class="container-fluid">
            @inertia
        </div>
    </div>
{{-- Import scripts --}}
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>