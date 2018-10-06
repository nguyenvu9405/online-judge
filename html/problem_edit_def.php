<?php
include "core/init.php";
include "head.php";

$prob_setting_tab_info = array("name"=>"def");
if (InputGet::existField("prob_id"))
{
    $prob = Problem::selectProblem("problems.id=?",array(InputGet::get("prob_id")));
    if (empty($prob))
    {
        Redirect::to404();
    }
}
else
{
    Redirect::to("/index.php");
}

if (empty($cuser))
{
    Session::setFlash("Problem Settings","You need to log in first before modifying the problem",1);
    Redirect::to("index.php");
    die();
}

if (!$cuser->canEditProblem($prob))
{
    Session::setFlash("Problem Settings","You don't have the permission to modify the problem",1);
    Redirect::to("index.php");
    die();
}

$rule = array(
    "title"=>Validation::$ProblemProperties["title"],
    "code"=>array(
        'required'=>true,
        'regex'=>array(
            'ex'=>'^[A-Z0-9]{3,12}$',
            'guide'=>'Use 3-12 uppercase letters and numbers'
        ),
        'unique'=>array(
            'table'=>'problems',
            'field'=>'code',
            'where'=>' AND id!='.$prob->getId(),
            'guide'=>'This code is already used'
        )
    ),
    "definition"=>Validation::$ProblemProperties["definition"]
);


if (InputPost::exist())
{
    $problem_data = array(
        "title"=>InputPost::get("title"),
        "code"=>InputPost::get("code"),
        "definition"=>InputPost::get("definition")
    );

    $validate = new Validation($rule);
    if ($validate->judge($problem_data))
    {
        if ($prob->updateDB($problem_data))
        {
            $prob->update($problem_data);
            Session::flashPanel(array(1,"Update the problem sucessfully"));
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
<?php
include "header.php";
?>
<div class="content">
    <div class="grid-container">
        <div class="col-s-12 col-m-9" id="main-col">
            <div class="card panel">
                <div class="header-container space-around darker">
                    <div class="title">
                        <span>Edit definition</span>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="body-container">
                    <form method="post" action="" id="problem_definition_edit_form">
                        <div class="grid-container no-row-gap">

                            <div class="input-field col-s-12 col-m-6">
                                <div class="label">
                                    <label for="code">Title *</label>
                                </div>
                                <input id="title" name="title" type="text" spellcheck="false" value="<?php
                                    if (InputPost::exist())
                                    {
                                        echo InputPost::get("title");
                                    }
                                    else
                                    {
                                        echo $prob->getTitle();
                                    }
                                ?>">
                                <?php
                                    if ($errs && $errs["title"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["title"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                           
                                                <span class=\"helper-text hint\">                                            
                                                    {$rule["title"]["regex"]["guide"]}
                                                </span>
                                            ";
                                    }
                                ?>
                            </div>

                            <div class="input-field col-s-12 col-m-6">
                                <div class="label">
                                    <label for="code">Short code *</label>
                                </div>
                                <input id="code" name="code" type="text" spellcheck="false" value="<?php
                                    if (InputPost::exist())
                                    {
                                        echo InputPost::get("code");
                                    }
                                    else{
                                        echo $prob->getCode();
                                    }
                                ?>">
                                <?php
                                    if ($errs && $errs["code"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["code"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["code"]["regex"]["guide"]}
                                            </span>
                                        ";
                                    }
                                ?>
                            </div>

                            <div class="input-field col-s-12">
                                <div class="label">
                                    <label for="code">Definition *</label>
                                </div>
                                <textarea name="definition" id="definition">
                                    <?php
                                        if (InputPost::exist())
                                        {
                                            echo InputPost::get("definition");
                                        }
                                        else
                                        {
                                            echo $prob->getDefinition();
                                        }
                                    ?>
                                </textarea>
                                    <?php
                                    if ($errs && $errs["definition"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["definition"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["definition"]["regex"]["guide"]}
                                            </span>
                                        ";
                                    }
                                    ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="footer-container">
                    <input type="submit" value="save" class="raise-button" form="problem_definition_edit_form">
                </div>
            </div>
        </div>
        <div class="col-s-12 col-m-3">
            <?php
                include_once "problem_settings_panel.php";
                include_once "problem_info_panel.php";
            ?>
        </div>

    </div>
</div>
<?php
include "footer.php";
?>
<script src="/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace("definition",
        {
            extraPlugins: "image2",
            customConfig: "/ckeditor/custom-config.js",
            contentsCss: "/ckeditor/custom-contents-input.css"
        });



    var titleInput = document.getElementById("title");
    var titleRegex = new RegExp('<?php echo $rule["title"]["regex"]["ex"] ?>');
    titleInput.addEventListener("focusout",function(){
        if (!titleRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });

    titleInput.addEventListener("input",function(){
        if (titleRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
        }
    });

    var codeInput = document.getElementById("code");
    var codeRegex = new RegExp('<?php echo $rule["code"]["regex"]["ex"]; ?>');
    codeInput.addEventListener("focusout",function(){
        if (!codeRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });

    codeInput.addEventListener("input",function(){
        if (codeRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
        }
    });

</script>
</body>
