<?php
include "core/init.php";
include "head.php";
$prob_setting_tab_info = array("name"=>"tags");
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

$rule_tags = Validation::$ProblemTags;

if (InputPost::exist())
{
    $tags_data = array(
        "tags"=>json_decode(InputPost::get("tags"))
    );
    $validate_tags = new Validation($rule_tags);
    if ($validate_tags->judge($tags_data))
    {
        if ($prob->updateTagsDB($tags_data["tags"]))
        {
            Session::flashPanel(array(1,"Updating the problem successfully!"));
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
        $errs = $validate_tags->getErrors();
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
                        <span>Update tags</span>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="body-container">
                    <form class="tag-form" method="post" action="" id="problem_tags_edit_form">
                        <div class="grid-container no-row-gap">
                            <div class="input-field col-s-12">
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
                    </form>
                </div>
                <div class="footer-container">
                    <input type="submit" value="save" class="raise-button" form="problem_tags_edit_form">
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
<script>var tagsValidation = true; </script>
<script src="Javascript/tags.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<script>
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
        else
        {
            $tags = Problem::selectTags("problem_id=?",array($prob->getId()));
            if ($tags)
            {
                foreach ($tags as $tag)
                {
                    echo "addTag('{$tag["tag"]}');";
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
</script>
</body>
