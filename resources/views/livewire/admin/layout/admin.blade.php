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
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 max-w-full flex">
    @include('livewire.admin.layout.sidebar')
    <main class="flex-1 p-8 overflow-x-auto w-full">
        {{ $slot }}
    </main>
</div>
    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>