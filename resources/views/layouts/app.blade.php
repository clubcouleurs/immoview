<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Immoview') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/alpine.min.js') }}" defer
        ></script>
        <script src="{{ asset('js/init-alpine.js') }}"></script>
        
        <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
      rel="stylesheet" />

    <!-- Tailwind Elements styles-->
    <link
      rel="stylesheet"
      href="{{ asset('css/tw-elements.min.css') }}" />

    <!-- Tailwind CSS config -->
    <script src="{{ asset('css/3.3.0') }}"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          fontFamily: {
            sans: ["Roboto", "sans-serif"],
            body: ["Roboto", "sans-serif"],
            mono: ["ui-monospace", "monospace"],
          },
        },
        corePlugins: {
          preflight: false,
        },
      };
    </script>

    </head>
    <body class="font-sans antialiased">
        <!--<div class="min-h-screen bg-gray-100">
             @-include('layouts.navigation')

            Page Heading 
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{-- $header --}}
                </div>
            </header>

            Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
            <script src="{{ asset('js/tw-elements.umd.min.js') }}"></script>

    </body>
</html>
