<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//cdn.jsdelivr.net/npm/globe.gl"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>Sky-plane</title>
    </head>
    <body class="bg-black">
        <div>
            {{ $slot }}
        </div>
    </body>
</html>