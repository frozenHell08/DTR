<!DOCTYPE html>

<x-header>
    <link rel="stylesheet" href="/src/user.css">
    <link rel="stylesheet" href="/src/media.css">
</x-header>

<body>
    {{ $slot }}

    <x-session />

    <x-scripts>
        <script type="text/JavaScript" src="/src/user.js"></script>
    </x-scripts>
</body>