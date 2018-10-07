<?php
include "core/init.php";
include "head.php";
$status_array = array(
    "0"  =>"Any",
    "200"=>"Accepted",
    "101"=>"Time limit exceeded",
    "102"=>"Memory limit exceeded",
    "199"=>"Wrong answer",
    "197"=>"System error"

);
$compare_array = array(
    "0"=>"Unused",
    "1"=>"<=",
    "2"=>"=",
    "3"=>">="
);
$refine = array(
    "code"=> FILTER_DEFAULT,
    "user"=> FILTER_DEFAULT,
    "page"=>FILTER_VALIDATE_INT
);
$filter_refine = array(
    "status"=>FILTER_VALIDATE_INT,
    "lang_id"=>FILTER_VALIDATE_INT,
    "compare"=>array(
        "filter"=>FILTER_VALIDATE_INT,
        "options"=> array(
            "min_range"=>0,
            "max_range"=>3
        )
    ),
    "test_num"=>FILTER_VALIDATE_INT
);

$params= filter_input_array(INPUT_GET, $refine);
$filter = filter_var_array($_GET["filter"], $filter_refine);

?>
<body>
<div id="modal">
    <div class="panel card modal-content">
        <div class="header-container">
            <div class="title">
                <span>Submission</span>
                <a class="pull-right close-button">
                </a>
                <i class="material-icons">close</i>
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
if (empty($params["page"]))
    $cpage = 1;
else
    $cpage = $params["page"];
$num_per_page = 10;
$num_off_set = ($cpage-1)*$num_per_page;
$csub = Session::flash("sub_id");

if (!empty($params["code"])) {
    $prob = Problem::selectProblem("code=?",array($params["code"]));
    if ($params["user"]) {
        $tab_info["name"] = "you";
        $vars = array(
            "username" => $params["user"],
            "code" => $params["code"]
        );
        $filter_vars = array(
            "status"=> $filter["status"],
            "lang_id"=> $filter["lang_id"],
            "test_num"=> array(
                "value"=> $filter["test_num"],
                "compare"=> $filter["compare"]
            )
        );
        $subs = Submission::selectSubmission($num_per_page, $num_off_set, $vars, $filter_vars);
        $num_total = Submission::getSubmissionsNumber($vars, $filter_vars);
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
                    <?php
                        include_once "problem_info_panel.php";
                        include_once "filter_table.php";
                        include_once "submit_panel.php";
                        //include_once "problem_tag_panel.php";
                     ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        $tab_info["name"] = "sta";
        $vars = array(
            "code" => $params["code"]
        );
        $filter_vars = array(
            "status"=> $filter["status"],
            "lang_id"=> $filter["lang_id"],
            "test_num"=> array(
                "value"=> $filter["test_num"],
                "compare"=> $filter["compare"]
            )
        );
        $subs = Submission::selectSubmission($num_per_page, $num_off_set, $vars ,$filter_vars);
        $num_total = Submission::getSubmissionsNumber($vars, $filter_vars);
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
                    <?php
                        include_once "problem_info_panel.php";
                        include_once "filter_table.php";
                        include_once "submit_panel.php";
                        //include_once "problem_tag_panel.php";
                    ?>
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
