<?php
include "core/init.php";
include "head.php";
$prob_setting_tab_info = array("name"=>"testdata");
if (InputGet::existField("prob_id"))
{

    $prob = Problem::selectProblem("problems.id=?",array(InputGet::get("prob_id")));
    if (!$prob)
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
    "input_name"=>Validation::$ProblemProperties["input_name"],
    "output_name"=>Validation::$ProblemProperties["output_name"]
);

$rule_file = Validation::$ProblemTestcase;
$errs = array();

if (InputPost::exist())
{
    $problem_data = array(
        "input_name"=> InputPost::get("input_name"),
        "output_name"=> InputPost::get("output_name")
    );
    $validate = new Validation($rule);
    $validate_file = new Validation($rule_file);
    //die("ok");

    if ($validate->judge($problem_data) & $validate_file->judgeFile($_FILES["testcases"],"testcases"))
    {

        $zip = new ZipArchive();
        if (Problem::check_testcase_format($problem_data))
        {
            $db = DB::getInstance();
            try
            {
                $db->txBegin();
                $db->txQueryUpdate(
                   "UPDATE problems
                        SET `input_name`=?, `output_name`=? , `testcases_ver`=`testcases_ver`+1
                        WHERE id = ?",
                    array($problem_data["input_name"],$problem_data["output_name"],$prob->getId())
                );
                $db->txSelect("problems","id = ?", array($prob->getId()), array("testcases_ver"));
                $problem_data["testcases_ver"] = $db->getFirstItem()["testcases_ver"];
                $prob->update($problem_data);
                $prob->createDirectory($prob->getTestFolder());
                $zip->extractTo($prob->getDirectory($prob->getTestFolder()));
                $db->txCommit();
            }
            catch (Exception $e)
            {
                $db->txRollBack();
                Session::flashPanel(array(1,"Sorry, the problem cannot updated. Please try it again later"));
            }
            if (empty($errs))
            {
                Session::flashPanel(array(1,"You have updated testdata successfully!"));
            }
        }
        else
        {
            Session::flashPanel(array(0,ErrorMessages::getFormError()));
        }
    }
    else
    {
        $errs = array_merge($validate->getErrors(), $validate_file->getErrors());
        Session::flashPanel(array(0, ErrorMessages::getFormError()));
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
                        <span>Update testcases</span>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="body-container">
                    <form method="post" action="" id="problem_testdata_edit_form" enctype="multipart/form-data">
                        <div class="grid-container no-row-gap">
                            <input type="hidden" name="MAX_FILE_SIZE" value="25000000">
                            <div class="input-field col-s-12">
                                <div class="label">
                                    <label for="testcases">Testdata *</label>
                                </div>
                                <input id="testcases" type="file" name="testcases" accept="application/zip">
                                <?php
                                    if ($errs && $errs["testcases"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["testcases"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                           
                                                <span class=\"helper-text hint\">                                            
                                                    {$rule_file["guide"]}
                                                </span>
                                            ";
                                    }
                                ?>
                            </div>
                            <div class="input-field col-s-12 col-m-6">
                                <div class="label">
                                    <label for="code">Input filename *</label>
                                </div>
                                <input id="input_name" name="input_name" type="text" spellcheck="false" value="<?php
                                    if (InputPost::exist())
                                    {
                                        echo InputPost::get("input_name");
                                    }
                                    else
                                    {
                                        echo $prob->getInputName();
                                    }
                                ?>">
                                <?php
                                if ($errs && $errs["input_name"])
                                {
                                    echo "<span class='helper-text error'>{$errs["input_name"]}</span>";
                                }
                                else
                                {
                                    echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["input_name"]["regex"]["guide"]}
                                            </span>
                                        ";
                                }
                                ?>
                            </div>
                            <div class="input-field col-s-12 col-m-6">
                                <div class="label">
                                    <label for="code">Output filename *</label>
                                </div>
                                <input id="output_name" name="output_name" type="text" spellcheck="false" value="<?php
                                    if (InputPost::exist())
                                    {
                                        echo InputPost::get("output_name");
                                    }
                                    else
                                    {
                                        echo $prob->getOutputName();
                                    }
                                ?>">
                                <?php
                                if ($errs && $errs["output_name"])
                                {
                                    echo "<span class='helper-text error'>{$errs["output_name"]}</span>";
                                }
                                else
                                {
                                    echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["output_name"]["regex"]["guide"]}
                                            </span>
                                        ";
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="footer-container">
                    <input type="submit" value="save" class="raise-button" form="problem_testdata_edit_form">
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
    var input_nameInput = document.getElementById("input_name");
    var input_nameRegex = new RegExp("<?php echo $rule["input_name"]["regex"]["ex"]; ?>");
    input_nameInput.addEventListener("focusout",function(){
        if (!input_nameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });

    input_nameInput.addEventListener("input",function(){
        if (input_nameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
        }
    });

    var output_nameInput = document.getElementById("output_name");
    var output_nameRegex = new RegExp("<?php echo $rule["output_name"]["regex"]["ex"]; ?>");
    output_nameInput.addEventListener("focusout",function(){
        if (!output_nameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text error";
        }
    });

    output_nameInput.addEventListener("input",function(){
        if (output_nameRegex.test(this.value))
        {
            this.nextElementSibling.className = "helper-text hint";
        }
    });

    var testcasesInput = document.getElementById("testcases");
    testcasesInput.addEventListener("change",function () {
        var maxSize = <?php echo $rule_file["size"]["max"]["value"]; ?>;
        if(typeof this.files[0]=="undefined" )
        {
            this.nextElementSibling.className = "helper-text error";
            this.nextElementSibling.textContent = "This field is required";
        }
        else
        {
            var file= this.files[0];
            if (file.size > maxSize)
            {
                this.nextElementSibling.className = "helper-text error";
                this.nextElementSibling.textContent = "<?php echo $rule_file["size"]["max"]["guide"]; ?>";
            }
            else
            {
                this.nextElementSibling.className = "helper-text hint";
                this.nextElementSibling.textContent = "<?php echo $rule_file["guide"]; ?>";
            }
        }
    });
</script>
</body>
