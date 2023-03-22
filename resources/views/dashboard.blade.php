<x-layout>
    <!-- meow welcome! -->
    <h2>Daily Time Record</h2>

    <section class="form-box timecard">
        <h2>Checks</h2>

        <form action="{{ route('timein', ['user' => $user->id]) }}" method="post">
            @csrf
            <button type="submit" class="btnTime">TIME IN</button>
        </form>

        <!-- <form action="/dashboard/{ $user->id }/timein" method="post">
            <button type="submit" class="btnTime">TIME IN</button>
        </form> -->

        <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post">
            @csrf
            <button type="submit" class="btnTime">TIME OUT</button>
        </form>
    </section>

    <section>
        <h2>Time Table</h2>
        <p>{{ $user->firstName }}</p>
    </section>
</x-layout>