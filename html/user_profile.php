<?php
include "core/init.php";
include "head.php";
?>

<body>
<?php
$params = $_GET;
$tab_info = array("name"=>"inf");

if (InputGet::existField("user"))
{

    $puser = User::getUserByUsername(InputGet::get("user"));
}
else if ($cuser)
    $puser = $cuser;
else
{
    Redirect::to("/index.php");
}
include "header.php";
?>
<div class="content">
    <div class="grid-container">
        <div class="col-s-12 col-m-9" id="main-col">
            <div class="panel card">
                <?php include "user_profile_tab.php" ?>
                <div class="header-container">
                    <div class="title">
                        <span class="non-upper"><?php echo $puser->getUsername()?></span>
                    </div>
                    <div class="divider margin-8"></div>
                </div>
                <div class="body-container grid-container">
                    <div class="label-normal col-s-12 col-m-3">
                        <label>Name</label>
                    </div>
                    <div class="col-s-12 col-m-9">
                        <?php echo $puser->getName();?>
                    </div>
                    <div class="label-normal col-s-12 col-m-3">
                        <label>Email</label>
                    </div>
                    <div class="col-s-12 col-m-9">
                        <?php echo $puser->getEmail() ;?>
                    </div>
                    <?php
                        if ($puser->getDOB())
                        {
                            $dob = new DateTime($puser->getDOB());
                    ?>
                            <div class="label-normal col-s-12 col-m-3">
                                <label>Birthday</label>
                            </div>
                            <div class="col-s-12 col-m-9">
                                <?php echo $dob->format("M d, Y") ;?>
                            </div>
                    <?php
                        }
                        if ($puser->getWorkPlace()) {
                            ?>
                            <div class="label-normal col-s-12 col-m-3">
                                <label>School/Company</label>
                            </div>
                            <div class="col-s-12 col-m-9">
                                <?php echo $puser->getWorkPlace(); ?>
                            </div>
                            <?php
                        }
                    ?>
                </div>
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
<?php include "footer.php";?>
</body>
