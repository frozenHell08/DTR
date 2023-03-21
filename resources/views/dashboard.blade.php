<x-layout>
    <!-- meow welcome! -->
    <h2>Daily Time Record</h2>

    <section>
        <h2>Checks</h2>

        <form action="#" method="post">
            <button type="submit" class="btnTime">TIME IN</button>
        </form>

        <form action="/dashboard/{id}/timeout" method="post">
            <button type="submit" class="btnTime">TIME OUT</button>
        </form>
    </section>

    <section>
        <h2>Time Table</h2>
        <p>{{ $user->firstName }}</p>
    </section>
</x-layout>