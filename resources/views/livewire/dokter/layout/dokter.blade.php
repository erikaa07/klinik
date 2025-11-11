<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Klinik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Jika pakai Vite (Laravel 9+): -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div class="flex w-full">
        <div class="w-64 bg-gray-800 text-white">
            @livewire('dokter.sidebar')
        </div>
        <div class="flex-1 p-6 bg-gray-100">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>