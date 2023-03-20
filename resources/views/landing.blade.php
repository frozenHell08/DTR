<x-layout>
    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Login</h2>
            <form action="#">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" required placeholder=" ">
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                    <input type="password" required>
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
            <form action="#">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" required placeholder=" ">
                    <label>Name</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="phone-portrait-outline"></ion-icon>
                    </span>
                    <input type="number" required placeholder=" ">
                    <label>Mobile Number</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" required placeholder=" ">
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                    <input type="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</x-layout>