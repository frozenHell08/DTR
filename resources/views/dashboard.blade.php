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
                    <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post" id="timeout-form">
                        @csrf
                        <button type="submit" class="btnTime btn-two" id="btnOut" onclick="return confirmTimeout()">TIME OUT</button>
                    </form>
                </div>

            </div>

            <div class="display">
                <span>Today is {{ now()->format('F d, Y') }}</span>
                <span>Time-in : {{ $timeintoday }} </span>
                <span>Time out : {{ $timeouttoday }} </span>
            </div>

        </section>

        <section class="dashdisplay">
            <div class="timetable">
                <table>
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
        </section>
    </div>
</x-layout>