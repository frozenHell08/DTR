<!DOCTYPE html>

<x-header>
    <link rel="stylesheet" href="/src/admin.css">
    <link rel="stylesheet" href="/src/media.css">
</x-header>

<body>
    {{ $slot }}

    <x-session />

    <x-scripts>
        <script type="text/JavaScript" src="/src/admin.js"></script>
    </x-scripts>
</body>