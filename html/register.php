<?php
include "core/init.php";
include "head.php";

if ($cuser)
{
    Redirect::to("index.php");
}

$rule = Validation::$Register;

if (Input::exist())
{

    $user_data = array(
        "username"=>Input::get("username"),
        "password"=>Input::get("password"),
        "password_again"=>Input::get("password"),
        "email"=>Input::get("email"),
        "name"=>Input::get("name"),
        "workplace"=>Input::get("workplace"),
        "group_num"=>0
    );
    if (Input::get("dob"))
    {
        $user_data["dob"]= Input::get("dob");
    }
    $validate = new Validation($rule);

    if ($validate->judge($user_data))
    {

        unset($user_data["password_again"]);
        $user_data["password"] = Hash::password($user_data["password"]);
        $new_user = new User($user_data);
        if ($new_user->register())
        {
            Session::flashPanel(array(1,"You have registered successfully!"));
            Redirect::to("login.php");
        }
        else
        {
            Session::flashErrorMsg(ErrorMessages::getDBMsg());
            Redirect::to("/error_page");
        }
    }
    else
    {
        Session::flashPanel(array(0,ErrorMessages::getFormError()));
        $errs = $validate->getErrors();
    }
}

?>

<body>
<?php include "header.php"?>

<div class="content">
    <div class="grid-center">
        <div id="main-col" style="width: 100%; max-width: 600px">
            <div class="card multiform-container register-box" >
                <div class="header-container darker space-around inner-center">
                    <div class="title">
                        <span>Register</span>
                    </div>
                </div>
                <div class="body-container">
                    <form method="post" action="" id="register-form">
                        <div class="sub-container">
                            <div class="sub-header">
                                <label>
                                    Account
                                </label>
                            </div>
                            <div class="sub-content grid-container no-row-gap">
                                <div class="input-field col-s-12 col-m-12">
                                    <div class="label">
                                        <label for="username">Username *</label>
                                    </div>
                                    <input id="username" name="username" type="text" spellcheck="false"
                                           value="<?php echo InputPost::get("username"); ?>"
                                    >
                                    <?php
                                    if ($errs && $errs["username"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["username"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["username"]["regex"]["guide"]}
                                            </span>
                                        ";
                                    }
                                    ?>
                                </div>
                                <div class="input-field col-s-12 col-m-6">
                                    <div class="label">
                                        <label for="password">Password *</label>
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
                                <div class="input-field col-s-12 col-m-6">
                                    <div class="label">
                                        <label for="password_again">Confirm your password *</label>
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
                                <div class="input-field col-s-12 col-m-12">
                                    <div class="label">
                                        <label for="email">Email *</label>
                                    </div>
                                    <input id="email" name="email" type="email" spellcheck="false"
                                           value="<?php echo InputPost::get("email"); ?>"
                                    >
                                    <span class="helper-text hint">Example: david@gmail.com</span>
                                </div>
                            </div>
                            <div class="sub-container">
                                <div class="sub-header">
                                    <label>
                                        User info
                                    </label>
                                </div>
                                <div class="sub-content  grid-container no-row-gap">
                                    <div class="input-field col-s-12 col-m-6">
                                        <div class="label">
                                            <label for="name">Fullname *</label>
                                        </div>
                                        <input id="name" name="name" type="text" spellcheck="false"
                                               value="<?php echo InputPost::get("name"); ?>"
                                        >
                                        <?php
                                        if ($errs && $errs["name"])
                                        {
                                            echo "<span class='helper-text error'>{$errs["name"]}</span>";
                                        }
                                        else
                                        {
                                            echo "
                                          <span class=\"helper-text hint\">{$rule["name"]["regex"]["guide"]}</span>                                        
                                        ";
                                        }
                                        ?>
                                    </div>
                                    <div class="input-field col-s-12 col-m-6">
                                        <div class="label">
                                            <label for="workplace">Workplace</label>
                                        </div>
                                        <input id="workplace" name="workplace" type="text" spellcheck="false"
                                               value="<?php echo InputPost::get("workplace"); ?>"
                                        >
                                        <?php
                                        if ($errs && $errs["workplace"])
                                        {
                                            echo "<span class='helper-text error'>{$errs["workplace"]}</span>";
                                        }
                                        else
                                        {
                                            echo "
                                          <span class=\"helper-text hint\">{$rule["workplace"]["regex"]["guide"]}</span>                                        
                                        ";
                                        }
                                        ?>
                                    </div>

                                    <div class="input-field col-s-12 col-m-6">
                                        <div class="label">
                                            <label for="dob">Birthday</label>
                                        </div>
                                        <input id="dob" name="dob" type="date" spellcheck="false"
                                               value="<?php
                                               if (Input::existField("dob"))
                                               {
                                                   $dob = new DateTime(Input::get("dob"));
                                                   echo $dob->format("Y-m-d");
                                               }

                                               ?>"
                                        >
                                        <span class="helper-text hint"></span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </form>
                </div>

                <div class="footer-container inner-center">
                    <input type="submit" value="submit" class="raise-button" form="register-form">

                </div>

            </div>
        </div>

    </div>
</div>
<?php include "footer.php"?>
<script>
    var usernameInput = document.getElementById("username");
    var usernameRegex = new RegExp("<?php echo $rule["username"]["regex"]["ex"]; ?>");
    usernameInput.addEventListener("focusout",function () {
        if (!usernameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });
    usernameInput.addEventListener("input",function () {
        if (usernameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
            this.nextElementSibling.textContent = "<?php echo $rule["username"]["regex"]["guide"]; ?>";
        }
    });
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

    var emailInput = document.getElementById("email");
    emailInput.addEventListener("focusout",function(){
        if (this.validity.typeMismatch)
        {
            this.nextElementSibling.className = "helper-text error";
            this.nextElementSibling.textContent = "Incorrect format";
        }
    });
    emailInput.addEventListener("input",function(){
        if (!this.validity.typeMismatch)
        {
            this.nextElementSibling.className = "helper-text hint";
            this.nextElementSibling.textContent = "Example: david@gmail.com";
        }
    });
    var nameInput = document.getElementById("name");
    var nameRegex = new RegExp('<?php echo $rule["name"]["regex"]["ex"];?>');
    nameInput.addEventListener("focusout",function () {
        if (!nameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });
    nameInput.addEventListener("input",function () {
        if (nameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
        }
    });

    var workplaceInput = document.getElementById("workplace");
    var workplaceRegex =  new RegExp('<?php echo $rule["workplace"]["regex"]["ex"]; ?>');
    workplaceInput.addEventListener("focusout",function(){
        if (!workplaceRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });
    workplaceInput.addEventListener("input",function () {
        if (workplaceRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
        }
    });
    // var form = document.getElementById("register-form");
    // form.addEventListener("submit",function(e)
    // {
    //     var errors = [];
    //     if (!usernameRegex.test(usernameInput.value)) errors.push("username");
    //     if (!passwordRegex.test(passwordInput.value)) errors.push("password");
    //     if (passwordAgainInput.value!==passwordInput.value) errors.push("confirmed password");
    //     if (emailInput.validity.typeMismatch) errors.push("email");
    //
    //     if (errors.length===0) return true;
    //     else
    //     {
    //         var str = "";
    //         for (var i=0, len=errors.length; i<len; i++)
    //         {
    //             if (i==0) str+=errors[i];
    //             else if (i===len-1) str+=" and "+errors[i];
    //             else str+=", "+errors[i];
    //         }
    //         addNoti("Register","Please correct these fields: "+str);
    //         e.preventDefault();
    //     }
    // });

</script>
</body>
