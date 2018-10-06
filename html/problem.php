<body>
<?php
$params=$_GET;
$tab_info["name"]="def";
$prob = Problem::selectProblem("code=?",array($params["code"]));
if (empty($prob))
{
    Redirect::to('/404');
}
include "header.php";
?>

<div class="content">
    <div class="grid-container">
        <div class="col-s-12 col-m-9" id="main-col">
            <div class="panel card">
                <?php
                    include "problem_tab.php";
                ?>
                <div class="only-body-container">
                    <div class="ckeditor-container">
                        <?php echo $prob->getDefinition(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-s-12 col-m-3">
            <?php
            if ($cuser && $cuser->canEditProblem($prob))
            {
                include_once "problem_settings_panel.php";
            }
            ?>
            <?php include_once "problem_info_panel.php"; ?>
            <?php include_once "submit_panel.php"; ?>
            <?php include_once "problem_tag_panel.php"; ?>

        </div>
    </div>
</div>
<?php include "footer.php"?>
</body>

