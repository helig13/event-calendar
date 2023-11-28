<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Calendar' }}</title>
</head>
<body>
<header>
    <div class="flex flex-col bg-dark1 w-full px-[200px]">
        <div class="grid grid-cols-2 w-full p-2 mt-4">
            <div class="w-full flex flex-row text-white ">
                <div class="label">
                    <div class="text-wrapper p-2">LOGO</div>
                </div>
            </div>
            <div class="w-full flex flex-row text-white nav">
                <div class="flex w-full justify-between items-center">
                    <div class="">Main</div>
                    <div class="">Events</div>
                    <div class="">Calendar</div>
                    <div class="">FAQ</div>
                </div>
            </div>
        </div>
        <span class="w-full p-[1px] bg-red1 opacity-10"></span>
    </div>

</header>
<main>
    @if (session()->has('message'))
        <div x-data="{ show: true, message: '{{ session('message') }}' }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform translate-y-full opacity-0"
             x-transition:enter-end="transform translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="transform translate-y-0 opacity-100"
             x-transition:leave-end="transform translate-y-full opacity-0"
             class="fixed bottom-10 right-10 px-4 bg-modal items-center h-[50px] rounded-2xl text-day">
            <div class="w-full h-full flex items-center justify-center">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="px-[200px] bg-dark1">
        {{ $slot }}
    </div>
</main>
<footer>

    <div class="flex flex-col bg-dark1 w-full px-[200px]">
        <div class="w-full p-[1px] bg-red1 opacity-10 mt-4"></div>
        <div class="flex flex-col w-full p-2 mt-4">
            <div class="w-full flex justify-center text-white ">
                <div class="label">
                    <div class="text-wrapper p-2">LOGO</div>
                </div>
            </div>
            <div class="w-full flex flex-row text-white nav">
                <div class="flex w-full justify-between items-center mt-4 mb-4 px-[200px]">
                    <div class="">Main</div>
                    <div class="">Events</div>
                    <div class="">Calendar
                    </div>
                    <div class="">FAQ</div>
                </div>
            </div>
        </div>

    </div>

</footer>
@livewireScripts
</body>
</html>

