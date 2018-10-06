<?php
include "core/init.php";
include "head.php";
$txt = Session::flashErrorMsg();
if (!$txt) Redirect::to("index.php");
?>

<body>
<?php
include "header.php";
?>

<div class="content">
    <div class="grid-center">
        <div class="panel card" style="width: 100%; max-width: 720px;">
            <div class="header-container">
                <div class="title">
                    <span>Error</span>
                </div>
            </div>
            <div class="body-container">
                   <?php if ($txt) echo $txt; ?>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
</body>
