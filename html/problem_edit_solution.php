<?php
include "core/init.php";
include "head.php";
$prob_setting_tab_info = array("name"=>"sol");
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
    'sol_link'=>array(
        'regex'=>array(
            'ex'=>'^.{0,256}$',
            'guide'=>'Use a maximum of 256 characters')
    )
);

if (InputPost::exist())
{

    $problem_data = array(
        "sol_link"=>InputPost::get("sol_link"),
        "show_sol"=>InputPost::get("show_sol")
    );
    if ($problem_data["show_sol"]!="1")
    {
        $problem_data["show_sol"]="0";
    }

    if ($prob->updateDB($problem_data))
    {
        $prob->update($problem_data);
        Session::flashPanel(array(1,"Updating the problem successfully!"));
    }
    else
    {
        Session::flashErrorMsg(ErrorMessages::getDBMsg());
        Redirect::to("/error_page");
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
                        <span>Setting solution</span>
                    </div>
                </div>
                <div class="body-container">
                    <form method="post" action="" id="problem_cons_edit_form">
                        <div class="grid-container no-row-gap">
                            <div class="input-field col-s-12 ">
                                <div class="label">
                                    <label for="sol_link">Solution Link</label>
                                </div>
                                <input id="sol_link" name="sol_link" type="text" spellcheck="false" value="<?php
                                    if (InputPost::exist())
                                    {
                                        echo InputPost::get("sol_link");
                                    }
                                    else
                                    {
                                        echo $prob->getSolutionLink();
                                    }
                                ?>">
                                <?php
                                    if ($errs && $errs["sol_link"])
                                    {
                                        echo "<span class='helper-text error'>{$errs["sol_link"]}</span>";
                                    }
                                    else
                                    {
                                        echo "         
                                                               
                                                    <span class=\"helper-text hint\">                                            
                                                        {$rule["sol_link"]["regex"]["guide"]}
                                                    </span>
                                                ";
                                    }
                                ?>
                            </div>
                            <div class="col-s-12">
                                <input type="checkbox" id="show_sol" name="show_sol" value="1" style=""
                                    <?php
                                        if (InputPost::exist())
                                        {
                                            if (InputPost::get("show_sol")=="1")
                                                echo "checked";
                                        }
                                        else
                                        {
                                            if ($prob->showSol())
                                                echo "checked";
                                        }
                                    ?>
                                >
                                <label for="show_sol">Show solution</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="footer-container">
                    <input type="submit" value="save" class="raise-button" form="problem_cons_edit_form">
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

</body>
