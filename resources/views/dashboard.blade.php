<x-dash>
    <section class="profile">
        <div class="details">
            <img src="../res/smoke.jpg" alt="img" class="profpic">
            <span id="name">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</span>
            <span id="email">{{ auth()->user()->email }} </span>
        </div>

        <div class="today">
            <span>Today is {{ now()->format('F d, Y') }}</span>
            <span>Time-in today : {{ $timeintoday }} </span>
            <span>Time out today : {{ $timeouttoday }} </span>
        </div>

        <div class="btns">
            @if ($timeInRecordExists)
            <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post">
                @csrf
                <button type="submit" class="btnTime">
                    TIME OUT
                </button>
            </form>
            @else
            <form action="{{ route('timein', ['user' => $user->id]) }}" method="post">
                @csrf
                <button type="submit" class="btnTime">
                    TIME IN
                </button>
            </form>
            @endif

            <form action="/logout" method="post" class="btnLogout">
                @csrf
                <button type="submit">
                    Logout
                </button>
            </form>
        </div>
    </section>

    <main>
        <span>Welcome {{ auth()->user()->firstName }}!</span>

        <div class="tbl-container">
            <table class="timetable">
                <thead>
                    <th>Date</th>
                    <th>Time in</th>
                    <th>Time out</th>
                    <th>Duration</th>
                </thead>

                <tbody>
                    @foreach ($timetable as $timeentry)
                    <tr>
                        <td> {{ \Carbon\Carbon::parse($timeentry->date)->format('F d, Y') }} </td>
                        <td>
                            {{ \Carbon\Carbon::parse($timeentry->time_in)->format('F d, Y') }}
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            {{ \Carbon\Carbon::parse($timeentry->time_in)->format('H:i.s') }}
                        </td>

                        <td>
                            @php
                            $outentry = $timeentry->time_out;
                            @endphp
                            @if (! is_null($outentry) )
                            {{ \Carbon\Carbon::parse($timeentry->time_out)->format('F d, Y') }}
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            {{ \Carbon\Carbon::parse($timeentry->time_out)->format('H:i.s') }}
                            @endif
                        </td>
                        <td> {{ $timeentry->duration }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $timetable->links() }}
    </main>
</x-dash>