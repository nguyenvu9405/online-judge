<?php
include "core/init.php";
include "head.php";

if ($cuser)
{
    $rule = array(
        "name"=>Validation::$Register["name"],
        "workplace"=>Validation::$Register["workplace"],
        "birthday"=>Validation::$Register["birthday"]
    );
    if (Input::exist())
    {
        $user_data = array(
            "name"=>Input::get("name"),
            "workplace"=>Input::get("workplace"),
        );
        if (Input::get("dob")) $user_data["dob"] = Input::get("dob");
        $validate = new Validation($rule);
        if ($validate->judge($user_data))
        {
            if ($cuser->updateInfoUser($user_data)){
                Session::flashPanel(array(1,"Updated your profile sucessfully!"));
                Redirect::to("/user_profile");
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
}
else Redirect::to("/index");
?>
<body>
<?php include "header.php"; ?>
<div class="content">
    <div class="grid-center">
        <div id="main-col" style="width: 100%; max-width: 420px; margin-top: 2%">
            <div class="card panel" >
                <div class="header-container">
                    <div class="title">
                        <span>Edit profile</span>
                    </div>
                </div>
                <div class="body-container">
                    <form method="post" action="" id="user_edit_profile_form">
                        <div class="grid-container no-row-gap">
                            <div class="input-field col-s-12 col-m-12">
                                <div class="label">
                                    <label for="name">Fullname *</label>
                                </div>
                                <input id="name" name="name" type="text" spellcheck="false"
                                       value="<?php echo $cuser->getName(); ?>"
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
                            <div class="input-field col-s-12 col-m-12">
                                <div class="label">
                                    <label for="workplace">Workplace</label>
                                </div>
                                <input id="workplace" name="workplace" type="text" spellcheck="false"
                                       value="<?php echo $cuser->getWorkPlace(); ?>"
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

                            <div class="input-field col-s-12 col-m-12">
                                <div class="label">
                                    <label for="dob">Birthday</label>
                                </div>
                                <input id="dob" name="dob" type="date" spellcheck="false"
                                       value="<?php
                                       if ($cuser->getDOB())
                                       {
                                           $dob = new DateTime($cuser->getDOB());
                                           echo $dob->format("Y-m-d");
                                       }
                                       ?>"
                                >
                                <span class="helper-text hint"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="footer-container">
                    <input type="submit" class="raise-button" value="Save" form="user_edit_profile_form">
                </div>
            </div>
        </div>

    </div>
</div>
<?php include "footer.php"; ?>
<script>
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
</script>
</body>
