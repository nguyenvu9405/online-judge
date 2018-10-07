<?php
include "core/init.php";
include "head.php";
$params=$_GET;
$tab_info["name"]="sub";
?>

<body>
<div class="content">
    <div class="grid-container" >
    <?php

        if ($params["code"])
        {

            $prob = Problem::selectProblem("code=?", array($params["code"]));
            if (!$prob) Redirect::to("/404");
            if (!$cuser)
            {
                $mess = array(
                    "title" => "Submit",
                    "content" => "You need to log in first before submitting your code"
                );
                include "header.php";
                ?>

                <div class="col-s-12 col-m-9" id="main-col">
                    <div class="panel card">
                        <?php
                        include "problem_tab.php";
                        include "message_panel.php";
                        ?>
                    </div>
                </div>
                <?php
            }
            else
            {

                if (!empty($_FILES))
                {
                    $sub_data = array(
                        "user_id" => $cuser->getId(),
                        "problem_id" => $prob->getId(),
                        "lang_id"=> InputPost::get("lang_id")
                    );
                    $new_sub = new Submission($sub_data);
                    if ($_FILES["submission"]["error"])
                    {
                        if (InputPost::existField("source_code"))
                        {
                            $source_code= InputPost::get("source_code");
                            if ($new_sub->judgeCode($source_code))
                            {
                                Redirect::to("/status?code={$prob->getCode()}&user={$cuser->getUsername()}");
                            }
                            else
                            {
                                Redirect::to("/error_page");
                            }
                        }
                        else
                        {
                            Session::flashErrorMsg("Cannot submit your code");
                            Redirect::to("/error_page");
                        }
                    }
                    else
                    {
                        if ($new_sub->judge())
                        {
                            Redirect::to("/status?code={$prob->getCode()}&user={$cuser->getUsername()}");
                        }
                        else
                        {
                            Redirect::to("/error_page");
                        }
                    }
                }
                include "header.php";
                ?>
                <div class="col-s-12 col-m-9" id="main-col">
                    <div class="panel card">
                        <?php include "problem_tab.php"; ?>
                        <div class="header-container">
                                <div class="title" style="display: inline-block; margin-right: 16px">
                                    <span>Submit</span>
                                </div>
                                <select class="lang" name="lang_id" id="lang_select" form="problem-submit-form">
                                    <?php
                                    echo Lang::getLangsOptions($cuser->getLatestLangId());
                                    ?>
                                </select>

                        </div>
                        <div class="body-container">
                            <form action="/submit.php?code=<?php echo $prob->getCode();?>" method="post" id="problem-submit-form" enctype="multipart/form-data">
                                    <div class="input-field">
                                        <div class="label">
                                            <label for="source_code">Submit by file</label>
                                        </div>
                                        <textarea id="source_code" name="source_code" style="display: none"></textarea>
                                        <div class="editor-input" id="code-editor" style="height: 240px; width: 100%"></div>
                                    </div>
                                    <div class="input-field item">
                                        <div class="label">
                                            <label for="code">or source code</label>
                                        </div>
                                        <input type="hidden" name="problem_id" value="<?php echo $prob->getId(); ?>">
                                        <input type="file" name="submission">
                                    </div>

                            </form>
                        </div>
                        <div class="footer-container">
                            <input type="submit" class="raise-button disabled-onclick" value="submit" form="problem-submit-form">
                        </div>
                    </div>
                </div>
                <?php
                }
        }
        else
        {
            Redirect::to("/404");
        }

    ?>
        <div class="col-s-12 col-m-3">
            <?php include_once "problem_info_panel.php";?>
            <?php include_once "problem_tag_panel.php"; ?>
        </div>
    </div>
</div>
<script src="/ace-builds/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("code-editor");
    editor.setTheme("ace/theme/clouds");
    var textArea = document.getElementById("source_code");
    var form = document.getElementById("problem-submit-form");
    var select_box = document.getElementById("lang_select");
    set_lang_mode(select_box.value);
    select_box.addEventListener("change",function(){
        set_lang_mode(select_box.value);
    });
    editor.clearSelection();
    form.addEventListener("submit",function () {
        textArea.textContent = editor.session.getValue();
    });

    function set_lang_mode(lang_id){
        var mode = select_box.value;
        if (mode==1) {
            editor.session.setMode("ace/mode/pascal");
            editor.session.setValue("program ideone;\n" +
                "begin\n" +
                "\t(* your code goes here *)\n" +
                "end.");
        }
        else if (mode==2) {
            editor.session.setMode("ace/mode/c_cpp");
            editor.session.setValue("#include <iostream>\n" +
                "using namespace std;\n" +
                "\n" +
                " int main() {\n" +
                "\n" +
                "   // your code here\n" +
                "\n" +
                "   return 0;\n" +
                "}");
        }
        else if (mode==3) {
            editor.session.setMode("ace/mode/c_cpp");
            editor.session.setValue("#include <iostream>\n" +
                "using namespace std;\n" +
                "\n" +
                " int main() {\n" +
                "\n" +
                "   // your code here\n" +
                "\n" +
                "   return 0;\n" +
                "}");
        }
    };
</script>
<?php
include "footer.php";
?>
</body>
