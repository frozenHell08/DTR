<x-dash>
    <section class="profile">
        <div class="details">
            <img src="../res/smoke.jpg" alt="img" class="profpic">
            <span id="name">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</span>
            <span id="email">{{ auth()->user()->email }} </span>
        </div>

        <div class="btns">
            <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post">
                @csrf
                <button type="submit" class="btnTime">
                    Time out
                </button>
            </form>

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
    </main>
</x-dash>