<x-dash>
    <div class="bg">
        <aside class="aside-edit">
            <span class="icon-close">
                <ion-icon name="close-outline"></ion-icon>
            </span>
            <figure class="img-container">
                <img src="" alt="" id="chosen-image">
                <figcaption id="file-name"></figcaption>
            </figure>
            <form action="{{ route('edit', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
                <!-- <form action="{{ secure_url('dashboard/' . $user->id . '/edit') }}" method="post" enctype="multipart/form-data"> -->
                @csrf
                <div class="img-box">
                    <input type="file" name="profpic" id="upload-img" accept="image/*">
                    <label for="upload-img">
                        <ion-icon name="image-outline"></ion-icon>
                        &nbsp Choose an image
                    </label>
                </div>

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" name="firstName" placeholder=" ">
                    <label>First Name</label>
                </div>

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" name="lastName" placeholder=" ">
                    <label>Last Name</label>
                </div>

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </aside>
    </div>
    <section class="profile">
        <div class="details">
            <div>
                <button class="btnEdit-popup">
                    <i class='bx bx-pencil'></i>
                </button>

                @if ($imageExists)
                @secure
                <img src="{{ secure_asset(str_replace('public', 'storage', $user->profile_picture)) }}" alt="image" class="profpic">
                @else
                <img src="{{ asset(str_replace('public', 'storage', $user->profile_picture)) }}" alt="image" class="profpic">
                @endsecure
                @else
                <img src="../res/monopuncher.png" alt="img" class="profpic">
                @endif
            </div>

            <span>{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</span>
            <span>{{ auth()->user()->email }} </span>
            <span>{{ $accHours }} of 486 hours</span>
        </div>

        <div class="today">
            <span>Today is {{ now()->format('F d, Y') }}</span>
            <span>Time-in today : {{ $timeintoday }} </span>
            <span>Time out today : {{ $timeouttoday }} </span>
        </div>

        <div class="btns">
            @if ($timeInRecordExists)
            <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post">
                <!-- <form action="{{ route('timeout', ['user' => $user->id]) }}" method="post"> -->
                @csrf
                <button type="submit" class="btnTime" onclick="confirmTimeout()">
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
                    LOGOUT
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
    <div class="printbtn">
        <button class="btnPrint-popup">
            <i class='bx bx-droplet bx-tada'></i>
        </button>
    </div>
    <div class="bg-print">
        <ul class="btnlist">
            <li class="list-item">
                <button id="cancel-print">
                    <ion-icon name="close-outline"></ion-icon>
                </button>
                <span class="tooltip">Close</span>
            </li>
            <li class="list-item">
                <button id="btnPrint">
                    <i class='bx bx-printer'></i>
                </button>
                <span class="tooltip">Print</span>
            </li>
            <li class="list-item">
                <input type="date" name="from" id="from" class="date-input">
                <label for="from"><i class='bx bx-calendar'></i></label>
                <span class="tooltip">From</span>
            </li>
            <li class="list-item">
                <input type="date" name="to" id="to" class="date-input">
                <label for="to"><i class='bx bx-calendar'></i></label>
                <span class="tooltip">To</span>
            </li>
        </ul>

        <section class="print-area" id="scroll-style" data-user-id="{{ auth()->user()->id }}">
            <article>
                <x-svg.cv type="logo" />
                <span>Time Sheet</span>
                <span><em>Employee Name : {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</em></span>
                <span id="daterange"><em>Time Record from : {{ \Carbon\Carbon::parse($rawTable[0]->date)->format('F d, Y') }}
                        to {{ \Carbon\Carbon::parse(now())->format('F d, Y') }} </em></span>
                <hr>
            </article>

            <div class="tbl-container">
                <table class="timetable" id="timetable">
                    <thead>
                        <th>Date</th>
                        <th>Time in</th>
                        <th>Time out</th>
                        <th>Duration</th>
                    </thead>

                    <tbody>
                        @foreach ($rawTable as $timeentry)
                        <tr>
                            <td> {{ \Carbon\Carbon::parse($timeentry->date)->format('F d, Y') }} </td>
                            <td>
                                {{ \Carbon\Carbon::parse($timeentry->time_in)->format('H:i.s') }}
                            </td>

                            <td>
                                @php
                                $outentry = $timeentry->time_out;
                                @endphp
                                @if (! is_null($outentry) )
                                {{ \Carbon\Carbon::parse($timeentry->time_out)->format('H:i.s') }}
                                @endif
                            </td>
                            <td> {{ $timeentry->duration }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <span id="totalhours"><strong> Total hours :</strong> {{ $accHours }} </span>
            </div>
            <article>
                <span><strong>Supervisor Signature over Printed Name</strong></span>
                <span><strong>Approved By</strong></span>
                <span><strong>Date</strong></span>
                <span><strong>Date</strong></span>
            </article>
            <footer>
                <x-svg.cv type="name" />
            </footer>
        </section>
    </div>
</x-dash>