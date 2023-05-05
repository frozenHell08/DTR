<!DOCTYPE html>

<x-header>
    <link rel="stylesheet" href="/src/style.css">   
</x-header>

<body>
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

    <x-session />

    <x-scripts>
        <script type="text/JavaScript" src="/src/script.js"></script>
    </x-scripts>
</body>