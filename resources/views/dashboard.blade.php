<x-layout>
    <!-- meow welcome! -->
    <h2>Daily Time Record</h2>

    <section>
        <h2>Checks</h2>

        <form action="{{ route('timein', ['id' => $user->id]) }}" method="post">
            <button type="submit">TIME IN</button>
        </form>

        <form action="/dashboard/{id}/timeout" method="post">
            <button type="submit">TIME OUT</button>
        </form>
    </section>

    <section>
        <h2>Time Table</h2>
    </section>
</x-layout>