<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cadastro de Clientes</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                color: #ccc;
            }

            body {
                font-family: Arial, sans-serif;
                overflow-x: hidden;
                background-color: #333;
            }

            .container {
                width: 100%;
                max-width: 100%;
            }

        </style>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <main class="container">
            <div id="app"></div>
        </main>
    </body>
</html>
