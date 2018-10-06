<?php
include "core/init.php";
include "head.php";
if ($cuser)
{
    $rule = array(
        "old_password"=>array(
                'required'=>true
        ),
        "password"=>Validation::$Register["password"],
        "password_again"=>Validation::$Register["password_again"]
    );
    if (Input::exist())
    {
        $user_data = array(
            "old_password"=>Input::get("old_password"),
            "password"=>Input::get("password"),
            "password_again"=>Input::get("password_again")
        );

        $validate = new Validation($rule);
        if ($validate->judge($user_data))
        {

            $old_password = Input::get("old_password");
            if (Hash::passwordVerify($old_password, $cuser->getPassword()))
            {
                unset($user_data["password_again"]);
                unset($user_data["old_password"]);
                $user_data["password"] = Hash::password($user_data["password"]);
                if ($cuser->updateInfoUser($user_data))
                {
                    Session::flashPanel(array(1, "You have changed the password sucessfully !"));
                    Redirect::to("/user_profile");
                }
                else
                {
                    Session::flashErrorMsg(ErrorMessages::getDBMsg());
                    Redirect::to("/user_profile");
                }
            }
            else
            {
                Session::flashPanel(array(0, ErrorMessages::getFormError()));
                $errs = array("old_password"=>"Wrong current password");
            }
        }
        else
        {
            Session::flashPanel(array(0, ErrorMessages::getFormError()));
            $errs = $validate->getErrors();
        }
    }
}
else
    Redirect::to("index.php");


?>
<body>
<?php include "header.php"; ?>
<div class="content">
    <div class="grid-center">
        <div id="main-col" style="width: 100%; max-width: 360px; margin-top: 2%;">
            <div class="card panel" >
                <div class="header-container">
                    <div class="title">
                        <span>Change password</span>
                    </div>
                </div>
                <div class="body-container">
                    <form method="post" action="" id="change_password_form">
                        <div class="grid-container no-row-gap">
                            <div class="input-field col-s-12">
                                <div class="label">
                                    <label for="old_password">Current password *</label>
                                </div>
                                <input id="old_password" name="old_password" type="password">
                                <?php
                                if ($errs && $errs["old_password"])
                                {
                                    echo "<span class='helper-text error'>{$errs["old_password"]}</span>";
                                }
                                ?>
                            </div>
                            <div class="input-field col-s-12">
                                <div class="label">
                                    <label for="password">New Password *</label>
                                </div>
                                <input id="password" name="password" type="password">
                                <?php
                                if ($errs && $errs["password"])
                                {
                                    echo "<span class='helper-text error'>{$errs["password"]}</span>";
                                }
                                else
                                {
                                    echo "                                        
                                        <span class=\"helper-text hint\">
                                            {$rule["password"]["regex"]["guide"]}
                                        </span>
                                    ";
                                }
                                ?>
                            </div>
                            <div class="input-field col-s-12">
                                <div class="label">
                                    <label for="password_again">Confirm your new password *</label>
                                </div>
                                <input id="password_again" name="password_again" type="password">
                                <?php
                                if ($errs && $errs["password_again"])
                                {
                                    echo "<span class='helper-text error'>{$errs["password_again"]}</span>";
                                }
                                else
                                {
                                    echo "
                                      <span class=\"helper-text hint\">Enter your password again</span>                                        
                                    ";
                                }
                                ?>

                            </div>
                        </div>
                    </form>

                </div>
                <div class="footer-container">
                    <input type="submit" class="raise-button" value="Save" form="change_password_form">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script>
    var passwordInput = document.getElementById("password");
    var passwordRegex = new RegExp("<?php echo $rule["password"]["regex"]["ex"];?>");
    passwordInput.addEventListener("focusout",function () {
        if (!passwordRegex.test(this.value))
            this.nextElementSibling.className = "helper-text error";

    });
    passwordInput.addEventListener("input",function () {
        if (passwordRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
            this.nextElementSibling.textContent = "<?php echo $rule["password"]["regex"]["guide"];?>";
        }
    });
    var passwordAgainInput = document.getElementById("password_again");
    passwordAgainInput.addEventListener("focusout",function () {
        if (this.value !== passwordInput.value)
        {
            this.nextElementSibling.className = "helper-text error";
            this.nextElementSibling.textContent = "This doesn't match your password";
        }
    });
    passwordAgainInput.addEventListener("input",function () {
        if (this.value == passwordInput.value)
        {
            this.nextElementSibling.className = "helper-text hint";
            this.nextElementSibling.textContent = "Enter your password again";
        }
    });
</script>
</body>
