<?php
include "core/init.php";
include "head.php";
if ($cuser)
{
    Redirect::to("index.php");
}
if (Input::exist())
{
    $res = User::login(Input::get("username"),Input::get("password"));
    if ($res["user"])
    {
        Session::flashPanel(array(1,"You have logged in successfully"));
        Redirect::back();
    }
    else
    {
        $err = $res["err"];
        Session::flashPanel(array(0,"Please correct the errors"));
    }
}
?>


<body>
<?php
include "header_for_login.php";
?>
<!--style="width: 100%; max-width: 320px; margin-top: 5%"-->
<div class="content">
    <div class="grid-center">
        <div id="main-col" style="width: 100%; max-width: 320px; margin-top: 5%">
            <div class="panel card">
                <div class="header-container">
                    <div class="title">
                        <span>Login</span>
                    </div>
                </div>
                <div class="body-container">
                    <form method="post" action="" id="login-form">
                        <div class="input-field">
                            <div class="label">
                                <label for="username">Username</label>
                            </div>
                            <input id="username" name="username" type="text" spellcheck="false">
                            <?php
                            if ($err && $err["username"])
                                echo "<div class='helper-text error'>{$err["username"]}</div>";
                            ?>
                        </div>
                        <div class="input-field">

                            <div class="label">
                                <label for="password">Password</label>
                            </div>
                            <input id="password" name="password" type="password">
                            <?php
                            if ($err && $err["password"])
                                echo "<div class='helper-text error'>{$err["password"]}</div>";
                            ?>
                        </div>
                    </form>
                </div>

                <div class="footer-container">
                    <div class="row-container">
                        <input type="submit" value="Login" class="raise-button" form="login-form">
                        <a href="register.php" class="flat-button">Sign up</a>
                    </div>
                    <div class="row-container">
                        <a href="forgot_pw.php" class="link warning">Forgot your password ?</a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php include "footer.php"?>
</body>

