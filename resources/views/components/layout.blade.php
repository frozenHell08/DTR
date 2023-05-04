<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>DTR</title>

<link rel="stylesheet" href="/src/style.css">
<link rel="stylesheet" href="/src/animations.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

<body class="mine">
    <header>
        <img class = "logo" src="/res/puncher.png" alt="">

        <nav class="navigation">
            <a href="/">Home</a>
            @auth

            <div class="formwrapper">
                <form action="/logout" method="post">
                    @csrf
                    <button class="btnLogout" type="submit">Log Out</button>
                </form>
            </div>
            @else
                <button class="btnLogin">Login</button>
            @endauth
        </nav>
    </header>

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

    @secure
    <script src="{{ secure_asset('res/particles.js-master/particles.js') }}"></script>
    @else
    <script src="{{ asset('res/particles.js-master/particles.js') }}"></script>
    @endsecure
    
    <script type="text/JavaScript" src="/src/script.js"></script>
    <!-- <script type="text/JavaScript" src="/src/access.js"></script> -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>