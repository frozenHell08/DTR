<x-layout>
    <div class="dashboard">
        <section class="dashheader">
            @auth
            <h2>Welcome, {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}!</h2>
            @endauth

            <div class="form-box timecard">
                <div class="glow-border">
                    <form action="{{ route('timein', ['user' => $user->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btnTime">TIME IN</button>
                    </form>
                </div>

                <div>
                    <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btnTime btn-two">TIME OUT</button>
                    </form>
                </div>

            </div>

            <div class="display">
                <span>Today is {{ now()->format('F d, Y') }}</span>
                <span>Time-in : 08:30.45</span>
                <span>Time out : {{ now()->format('H:i.s') }} </span>
            </div>

        </section>

        <section>??</section>
    </div>






    <!-- <h2>Daily Time Record</h2>

    <section class="form-box timecard">
        <h2>Checks</h2> -->

    <!-- <form action="{{ route('timein', ['user' => $user->id]) }}" method="post">
            @csrf
            <button type="submit" class="btnTime">TIME IN</button>
        </form>

        <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post">
            @csrf
            <button type="submit" class="btnTime">TIME OUT</button>
        </form> -->
    <!-- </section>

    <div>
        ? {{ $user->firstName }} <br>
        <pre>Date           Time In             Time Out</pre>
        @foreach( $user->timeData as $time )
        {{ $time->date }} &nbsp;&nbsp;
        {{ $time->time_in }} &nbsp;&nbsp;
        {{ $time->time_out }} <br>
        @endforeach -->

    <!-- @foreach ($user->timeData() as $user)
            <p>{{ $user->time_in }} {{ $user->time_out }}</p>
            
        @endforeach -->
    <!-- </div> -->
</x-layout>