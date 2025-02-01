<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-row">
        <div class="fixed h-screen w-64 bg-gray-900 text-white shadow-lg">
            @include('components.sidebar')
        </div>

        <div class="flex-1 flex flex-col ml-64">
            @if (isset($header))
            <header class="bg-gray-900 shadow px-6 py-5 text-white">
                <div class="w-full flex items-center">
                    <div class="flex-1">
                        <h2 class="font-semibold text-xl text-left">
                            {{ $header }}
                        </h2>
                    </div>

                    @if (isset($actions))
                    <div class="flex items-center">
                        {{ $actions }}
                    </div>
                    @endif
                </div>
            </header>
            @endif

            <div class="content-wrapper flex-1 p-6">
                <section class="content h-full">
                    <div class="container-fluid h-full">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</html>
