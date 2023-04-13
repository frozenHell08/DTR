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
            <!-- <form action="{{ route('edit', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data"> -->
            <form action="{{ secure_url('dashboard/' . $user->id . '/edit') }}" method="post" enctype="multipart/form-data">
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
                <img src="{{ secure_asset(str_replace('public', 'storage', $user->profile_picture)) }}" alt="image" class="profpic">
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
</x-dash>