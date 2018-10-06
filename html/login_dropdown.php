<div class="dropdown-container" id="login_dropdown" class="login-box">
    <div class="header-container">
        <div class="title">
            Login
        </div>
    </div>
    <div class="body-container">
        <form method="post" action="/login.php?rurl=<?php echo Server::getRequestURI(); ?>" id="login-form-nav">
            <div class="input-field">
                <div class="label">
                    <label>Username</label>
                </div>
                <input id="username_login_dropdown" name="username" type="text" spellcheck="false">
            </div>
            <div class="input-field">
                <div class="label">
                    <label for="password">Password</label>
                </div>
                <input id="password_login_dropdown" name="password" type="password" spellcheck="false">
            </div>
        </form>
    </div>

    <div class="footer-container">
        <div class="row-container">
            <input type="submit" value="Sign in" class="raise-button" form="login-form-nav">
            <a href="/register.php" class="flat-button">Sign up</a>
        </div>
        <div class="row-container">
            <a href="/forgot_pw.php" class="link warning">Forgot your password?</a>
        </div>
    </div>
</div>