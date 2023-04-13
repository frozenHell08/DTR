<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>DTR</title>

<link rel="stylesheet" href="/src/user.css">
<link rel="stylesheet" href="/src/media.css">
<link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

<body>
    {{ $slot }}

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="session">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session()->has('status'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="session">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <script type="text/JavaScript" src="/src/user.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>