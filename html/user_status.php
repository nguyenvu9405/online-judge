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


$params=$_GET;
if (!$params["user"])
{
    if ($cuser) $puser = $cuser;
    else
        Redirect::to("/index.php");
}
else
{
    $puser = User::getUser("username=?",array($params["user"]));
    if (!$puser) Redirect::to404();
}

if (!is_numeric(InputGet::get("page"))) $cpage = 1;
else $cpage = intval(InputGet::get("page"));
$num_per_page = 10;
$num_off_set = ($cpage-1)*$num_per_page;


if (!$params["code"])
{

    $tab_info["name"]="sta";
    $vars = array("user" => $puser->getUsername());

    $subs = Submission::selectSubmission($num_per_page, $num_off_set, $vars);

    $num_total = Submission::getSubmissionsNumber($vars);
    $total_page = ($num_total-1)/$num_per_page+1;
    include "header.php";
    ?>
    <div class="content">
        <div class="grid-container">
            <div class="col-s-12 col-m-9">
                <div class="panel card">
                    <?php
                    include "user_profile_tab.php";
                    include "status_table.php";
                    ?>
                </div>
            </div>
            <div class="col-s-12 col-m-3">
                <?php
                if ($puser && $cuser && $puser->getId()==$cuser->getId())
                    include "user_profile_settings.php";
                ?>
            </div>
        </div>
    </div>
    <?php
}
else
{

}
?>

<?php
    include "footer.php";
?>
</body>
