<?php
include "core/init.php";
include "head.php";

?>
<body>
<div id="modal">
    <div class="panel card modal-content">
        <div class="header-container">
            <div class="title">
                <span>Submission</span>
                <a class="pull-right close-button">
                    <i class="material-icons">close</i>
                </a>
            </div>
        </div>
        <div class="body-container">
            <div id="code-editor">function foo(items) {
                var x = "All this is syntax highlighted";
                return x;
                }</div>

        </div>
    </div>
</div>
<?php
include "header.php";
$params=$_GET;

if (!is_numeric(InputGet::get("page"))) $cpage = 1;
else $cpage = intval(InputGet::get("page"));
$num_per_page = 10;
$num_off_set = ($cpage-1)*$num_per_page;
$csub = Session::flash("sub_id");


if (!empty($params["code"])) {
    $prob = Problem::selectProblem("code=?",array($params["code"]));
    if ($params["user"]) {
        $tab_info["name"] = "you";
        $vars = array("user" => $params["user"], "code" => $params["code"]);
        $subs = Submission::selectSubmission($num_per_page, $num_off_set, $vars);
        $num_total = Submission::getSubmissionsNumber($vars);

        $total_page = ($num_total-1)/$num_per_page+1;
        ?>
        <div class="content">
            <div class="grid-container">
                <div class="col-s-12 col-m-9" id="main-col">
                    <div class="panel card">
                        <?php
                        include "problem_tab.php";
                        include "status_table.php";
                        ?>
                    </div>
                </div>


                <div class="col-s-12 col-m-3">
                    <?php include_once "problem_info_panel.php"; ?>
                    <?php include_once "submit_panel.php"; ?>
                    <?php include_once "problem_tag_panel.php"; ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        $tab_info["name"] = "sta";
        $vars = array("code" => $params["code"]);
        $subs = Submission::selectSubmission($num_per_page, $num_off_set, $vars);
        $num_total = Submission::getSubmissionsNumber($vars);
        $total_page = ($num_total-1)/$num_per_page+1;
        ?>
        <div class="content">
            <div class="grid-container">
                <div class="col-s-12 col-m-9" id="main-col">
                    <div class="panel card">

                        <?php
                        include "problem_tab.php";
                        include "status_table.php";
                        ?>
                    </div>
                </div>
                <div class="col-s-12 col-m-3">
                    <?php include_once "problem_info_panel.php"; ?>
                    <?php include_once "submit_panel.php"; ?>
                    <?php include_once "problem_tag_panel.php"; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
else {
    $subs = Submission::selectSubmission($num_per_page, $num_off_set);
    $num_total = Submission::getSubmissionsNumber();
    $total_page = ($num_total-1)/$num_per_page+1;
    ?>
    <div class="content">
        <div class="grid-container">
            <div class="col-s-12">
                <?php include "status_table.php"?>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php include "footer.php"; ?>

</body>
