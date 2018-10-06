<?php
include "core/init.php";
include "head.php";
if (empty($cuser))
{
    Session::setFlash("Problem Uploading","You need to log in first before uploading a problem",1);
    Redirect::to("index.php");
}

if (!$cuser->canUpload())
{
    Session::setFlash("Problem Uploading","You don't have the permission to upload a problem",1);
    Redirect::to("index.php");
}

$rule = Validation::$ProblemProperties;
$rule_file = Validation::$ProblemTestcase;
$rule_tags = Validation::$ProblemTags;
$errs = array();
if (Input::exist())
{
    $problem_data = array(
        "code"=>Input::get("code"),
        "title"=>Input::get("title"),
        "definition"=>Input::get("definition"),
        "timelimit"=>Input::get("timelimit"),
        "memorylimit"=>Input::get("memorylimit"),
        "input_name"=>Input::get("input_name"),
        "output_name"=>Input::get("output_name"),
        "testcases_ver"=> 0
    );
    $tags_data = array(
            "tags"=>json_decode(Input::get("tags"))
    );
    $validate = new Validation($rule);
    $validate_file = new Validation($rule_file);
    $validate_tags = new Validation($rule_tags);
    if ($validate->judge($problem_data) & $validate_tags->judge($tags_data) & $validate_file->judgeFile($_FILES["testcases"],"testcases"))
    {

        $zip = new ZipArchive();
        if(Problem::check_testcase_format($problem_data))
        {
            $problem_data["uploader_id"] = $cuser->getId();
            $problem_data["date"] = date("Y-m-d");
            $new_problem = new Problem($problem_data,$tags_data["tags"]);
            if ($new_problem->add($zip))
            {
                Session::flashPanel(array(1,"You have created a new problem successfully"));
                Redirect::to("/problems/".$new_problem->getCode());
            }
            else
            {
                Session::flashPanel(array(0,"Sorry, the problem cannot uploaded. Please try it again later"));
            }
        }
    }
    else
    {
        Session::flashPanel(array(0,ErrorMessages::getFormError()));
        $errs = array_merge($validate->getErrors(),$validate_tags->getErrors(), $validate_file->getErrors());
    }
}
?>

<body>
<?php
include "header.php";
?>

<div class="content">
    <div class="grid-center">
        <div id="main-col">
            <div class="card multiform-container">
                <div class="header-container">
                    <div class="title">
                        <i class="material-icons">file_upload</i>
                        <span>Problem Uploading</span>
                    </div>
                </div>
                <div class="body-container">
                    <form class="tag-form" method="post" action="" id="problem-uploading-form" enctype="multipart/form-data">
                        <div class="sub-container">
                            <div class="sub-header">
                                <label>
                                    Definition
                                </label>
                            </div>
                            <div class="sub-content grid-container no-row-gap">
                                <div class="input-field col-s-12 col-m-6">
                                    <div class="label">
                                        <label for="code">Title *</label>
                                    </div>
                                    <input value="<?php echo Input::get("title");?>" id="title" name="title" type="text" spellcheck="false">
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
                                    <input value="<?php echo Input::get("code");?>"  id="code" name="code" type="text" spellcheck="false">
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
                                    <textarea   name="definition" id="definition">
                                        <?php echo Input::get("definition");?>
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

                        </div>
                        <div class="sub-container">
                            <div class="sub-header">
                                <label>Test data</label>
                            </div>
                            <div class="sub-content grid-container no-row-gap">
                                <input type="hidden" name="MAX_FILE_SIZE" value="25000000">
                                <div class="input-field col-s-12">
                                    <div class="label">
                                        <label for="code">Testdata *</label>
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
                                    <input value="<?php echo Input::get("input_name");?>" id="input_name" name="input_name" type="text" spellcheck="false">
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
                                    <input value="<?php echo Input::get("output_name");?>"  id="output_name" name="output_name" type="text" spellcheck="false">
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
                        </div>
                        <div class="sub-container">
                            <div class="sub-header">
                                <label>Constraints</label>
                            </div>
                            <div class="sub-content grid-container no-row-gap">
                                <div class="input-field col-s-12 col-m-6">
                                    <div class="label">
                                        <label for="code">Time limit *</label>
                                    </div>
                                    <div class="input-unit">
                                        <input value="<?php echo Input::get("timelimit");?>"  id="timelimit" name="timelimit" type="number" spellcheck="false">
                                        <span>seconds</span>
                                    </div>
                                    <?php
                                    if ($errs && $errs["timelimit"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["timelimit"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["timelimit"]["guide"]}
                                            </span>
                                        ";
                                    }
                                    ?>
                                </div>
                                <!--                            //1048576-->
                                <div class="input-field col-s-12 col-m-6">
                                    <div class="label">
                                        <label for="code">Memory limit*</label>
                                    </div>
                                    <div class="input-unit">
                                        <input value="<?php echo Input::get("memorylimit");?>"  id="memorylimit" name="memorylimit" type="number" spellcheck="false">
                                        <span>mb</span>
                                    </div>
                                    <?php
                                    if ($errs && $errs["memorylimit"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["memorylimit"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule["memorylimit"]["guide"]}
                                            </span>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="sub-container">
                            <div class="sub-header">
                                <label>Categories</label>
                            </div>
                            <div class="sub-content">
                                <div class="input-field">
                                    <div class="label">
                                        <label for="code">Tags</label>
                                    </div>
                                    <input id="tag-values" name="tags" type="hidden" value="[]">
                                    <div id="tag-box" class="tag-box input-border-bot">
                                        <input id="tag-input" name="tag-input" class="tag-input" list="tag-options" autocomplete="off" aria-autocomplete="off">
                                        <datalist id="tag-options">
                                        </datalist>
                                    </div>

                                    <?php
                                    if ($errs && $errs["tags"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["tags"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                       
                                            <span class=\"helper-text hint\">                                            
                                                {$rule_tags["tags"]["guide"]}
                                            </span>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="footer-container">
                    <input type="submit" value="upload" class="raise-button" form="problem-uploading-form">
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "footer.php";?>
<script>var tagsValidation = true; </script>
<script src="/Javascript/tags.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<script>
    var editor = CKEDITOR.replace("definition",
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

    var timelimitInput = document.getElementById("timelimit");
    timelimitInput.addEventListener("focusout",function () {
        var value = parseInt(this.value);
        var par = this.parentNode;
        if (isNaN(value))
        {
            par.nextElementSibling.className = "helper-text error";
            par.nextElementSibling.textContent = '<?php echo $rule["timelimit"]["guide"];?>';
        }
        else
        {
            if (value > <?php echo $rule["timelimit"]["max"]["value"];?>)
            {
                par.nextElementSibling.className = "helper-text error";
                par.nextElementSibling.textContent = '<?php echo $rule["timelimit"]["max"]["guide"];?>';
            }
            else if (value < <?php echo $rule["timelimit"]["min"]["value"];?>)
            {
                par.nextElementSibling.className = "helper-text error";
                par.nextElementSibling.textContent = '<?php echo $rule["timelimit"]["min"]["guide"];?>';
            }
            else
            {
                par.nextElementSibling.className = "helper-text hint";
                par.nextElementSibling.textContent = '<?php echo $rule["timelimit"]["guide"];?>';
            }
        }
    });

    var memorylimitInput = document.getElementById("memorylimit");
    memorylimitInput.addEventListener("focusout",function () {
        var value = parseInt(this.value);
        var par = this.parentNode;
        if (isNaN(value))
        {
            par.nextElementSibling.className = "helper-text error";
            par.nextElementSibling.textContent = '<?php echo $rule["memorylimit"]["guide"];?>';
        }
        else
        {
            if (value > <?php echo $rule["memorylimit"]["max"]["value"];?>)
            {
                par.nextElementSibling.className = "helper-text error";
                par.nextElementSibling.textContent = '<?php echo $rule["memorylimit"]["max"]["guide"];?>';
            }
            else if (value < <?php echo $rule["memorylimit"]["min"]["value"];?>)
            {
                par.nextElementSibling.className = "helper-text error";
                par.nextElementSibling.textContent = '<?php echo $rule["memorylimit"]["min"]["guide"];?>';
            }
            else
            {
                par.nextElementSibling.className = "helper-text hint";
                par.nextElementSibling.textContent = '<?php echo $rule["memorylimit"]["guide"];?>';
            }
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
    <?php
        if (InputPost::exist())
        {
            if ($tags_data && $tags_data["tags"])
            {
                foreach ($tags_data["tags"] as $tag)
                {
                    echo "addTag('$tag');";
                }
            }
        }
    ?>

    tagInput.addEventListener("focusout",function () {
        var size = chosenTags.size;
        if (size<1 || size>5)
        {
            tagContainer.nextElementSibling.className = "helper-text error";
        }
    });

    var form = document.getElementById("problem-uploading-form");
    form.addEventListener("submit",function(e){
        var confirmed = confirm("Are you sure you want to upload this problem?");
        if (!confirmed) e.preventDefault();
    });

</script>

</body>
