<?php
include "core/init.php";
include "head.php";
$subs = Submission::selectLatestSumission(10);

?>
<body>
<?php include "header.php"; ?>
<div class="content">
    <div class="grid-container">
        <div class="col-s-12 col-m-9">
            <div class="panel card">
                <ul class="tab-bar">
                    <li>
                        <a href="/problems/<?php echo Input::get("code"); ?>">Definition</a>
                    </li>
                    <li>
                        <a href="/submit.php?code=<?php echo Input::get("code");  ?>">Submit</a>
                    </li>
                    <li>
                        <a class="active" href="/problem_status.php?code=<?php echo Input::get("code");  ?>">Your submissions</a>
                    </li>
                    <li>
                        <a href="#">Status</a>
                    </li>
                </ul>
                <?php include "status_table.php"?>
            </div>
        </div>


        <div class="col-s-12 col-m-3">
            <?php include_once "problem_info_panel.php"; ?>
            <?php include_once "submit_panel.php"; ?>
            <?php include_once "problem_tag_panel.php"; ?>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script src="Javascript/top_nav.js"></script>

</body>
