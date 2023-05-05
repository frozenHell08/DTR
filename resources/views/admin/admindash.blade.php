<x-adminlayout>
    <section>
        <div class="sidebar">
            <div class="logo-content">
                <div class="logo">
                    <img src="../res/monopuncher.png" alt="logo">
                    <h3>Puncher</h3>
                </div>
                <i class='bx bx-menu' id="btn"></i>
            </div>

            <ul class="list">
                <li class="list-item ">
                    <a href="#" data-target="home-content">
                        <i class='bx bx-home-alt-2'></i>
                        <span class="links-name">Home<span>
                    </a>
                    <span class="tooltip">Home</span>
                </li>
                <li class="list-item active">
                    <a href="#" data-target="users-content">
                        <i class='bx bx-user-circle'></i>
                        <span class="links-name">Users<span>
                    </a>
                    <span class="tooltip">Users</span>
                </li>
                <li class="list-item">
                    <a href="#" data-target="">
                        <i class='bx bx-cog'></i>
                        <span class="links-name">Control Panel<span>
                    </a>
                    <span class="tooltip">Control Panel</span>
                </li>
            </ul>
            <ul class="list-logout">
                <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit">
                            <i class='bx bx-exit'></i>
                            <span class="links-name">Logout<span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <main>
            <div id="home-content">
                <span>hello dashboard</span>
            </div>

            <div id="users-content" class="active">
                <h3>Employee List</h3>
                <hr>
                <div class="card-list">
                    @foreach ($users as $user)
                    <div class="card" data-id="{{ $user->id }}">
                        @if (\File::exists(public_path(str_replace('public', 'storage', $user->profile_picture))))
                        @secure
                        <img src="{{ secure_asset(str_replace('public', 'storage', $user->profile_picture)) }}" alt="image" class="profpic">
                        @else
                        <img src="{{ asset(str_replace('public', 'storage', $user->profile_picture)) }}" alt="image" class="profpic">
                        @endsecure
                        @else
                        <img src="../res/monopuncher.png" alt="img" class="profpic">
                        @endif

                        <span>{{ $user->lastName }}, {{ $user->firstName }} </span>
                        <span id="email">{{ $user->email }}</span>
                    </div>
                    @endforeach

                </div>
                <div id="profile">
                    <button id="close-profile">
                        <ion-icon name="close-outline"></ion-icon>
                    </button>
                    <div class="userdetails">
                        <img src="../res/monopuncher.png" alt="img" class="profpic" id="userpic">
                        <span id="user_name">Name</span>
                        <span id="user_email">email</span>

                        <hr>
                        <h6>Details</h6>

                        <article>
                            <span>
                                <p>Accumulated Time</p>
                                <p id="time"> {{ now() }} </p>
                            </span>
                            <span>
                                <p>Required Time</p>
                                <p>486 hours</p>
                            </span>
                            <span>
                                <p>Date Today</p>
                                <p>{{ now()->format('F d, Y') }}</p>
                            </span>
                            <span>
                                <p>Time in today</p>
                                <p id="tit">24:24.60</p>
                            </span>
                            <span>
                                <p>Time out today</p>
                                <p id="tot">24.24.60</p>
                            </span>
                            <span>
                                <p>Status</p>
                                <p>ONGOING</p>
                            </span>
                        </article>

                        <hr>
                        <h6>DTR</h6>

                        <div class="rangeselector">
                            <p>Date</p>

                            <label for="alltime">
                                <input type="radio" name="rctrl" id="alltime" value="true" checked>All Time
                            </label>

                            <label for="custom">
                                <input type="radio" name="rctrl" id="custom" value="false">Custom
                            </label>
                        </div>

                        <div class="dateselector">
                            <label for="from">From :</label>
                            <input type="date" name="from" id="from">

                            <label for="to">To :</label>
                            <input type="date" name="to" id="to">
                        </div>

                        <button class="btnPrint-popup" id="printprevbtn" data-id="0">Print DTR</button>
                    </div>
                    <div class="usertable">
                        TIME TABLE
                        <div class="tbl-container">
                            <table class="timetable" id="timetable">
                                <thead>
                                    <th>Date</th>
                                    <th>Time in</th>
                                    <th>Time out</th>
                                    <th>Duration</th>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <div class="bg-print">
        <ul class="btnlist">
            <li class="list-icon">
                <button id="cancel-print">
                    <ion-icon name="close-outline"></ion-icon>
                </button>
                <span class="tooltip">Close</span>
            </li>
            <li class="list-icon">
                <button id="btnPrint">
                    <i class='bx bx-printer'></i>
                </button>
                <span class="tooltip">Print</span>
            </li>
        </ul>

        <div class="print-area" id="scroll-style">
            <article>
                <x-svg.cv type="logo" />
                <span>Time Sheet</span>
                <span id="employname"><em></em></span>
                <span id="daterange"><em>Time Record from : </em></span>
                <hr>
            </article>

            <div class="tbl-container">
                <table class="timetable" id="timetableprint">
                    <thead>
                        <th>Date</th>
                        <th>Time in</th>
                        <th>Time out</th>
                        <th>Duration</th>
                    </thead>

                    <tbody id="tbprint">
                    </tbody>
                </table>
                <span id="totalhours"><strong> Total hours :</strong> </span>
            </div>
            <article>
                <span><strong>Supervisor Signature over Printed Name</strong></span>
                <span><strong>Approved By</strong></span>
                <span><strong>Date</strong></span>
                <span><strong>Date</strong></span>
            </article>
            <footer id="footer">
                <x-svg.cv type="name" />
            </footer>
        </div>
    </div>

</x-adminlayout>