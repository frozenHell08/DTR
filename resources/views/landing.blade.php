<x-layout>
    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Login</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" required placeholder=" ">
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Register</h2>
            <form method="POST" action="/register">
                @csrf
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" name="firstName" required placeholder=" ">
                    <label>First Name</label>
                    @error('firstName')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" name="lastName" required placeholder=" ">
                    <label>Last Name</label>
                    @error('lastName')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="phone-portrait-outline"></ion-icon>
                    </span>
                    <input type="number" name="mobileno" required placeholder=" ">
                    <label>Mobile Number</label>
                    @error('mobileno')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" required placeholder=" ">
                    <label>Email</label>
                    @error('email')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn" id="register">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</x-layout>