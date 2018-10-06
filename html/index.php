<?php
include "core/init.php";
include "head.php";

?>

<body>
<?php
    include "header.php";
?>
<div class="content">
    <div class="grid-container" id="main-col" style="max-width: 1080px; margin: auto">
<!--        <div class="col-s-12 col-m-6" id="main-col">-->
<!---->
<!--        </div>-->
        <div class="card panel col-s-12" >
            <div class="header-container" >
                <div class="display-3 text-center">
                     Hello coders!
                </div>
            </div>
            <div class="body-container text-center">
                <div class="sub-heading" style="width:100%; max-width: 800px; margin: auto; padding: 8px 0px;">
                    This website is dedicated to students who want to improve programming skills.
                    </br>This is a non-profit website so anybody can register, practice coding skills without any fee.
                    </br>Don't hesitate to register and train your skills with us now.
                </div>
            </div>
            <div class="footer-container inner-center" >
                <a href="problems.php" class="raise-button">Practice</a>
                <?php if (!$cuser) echo "<a href='register.php' class=\"flat-button\">Register</a>"?>
            </div>
        </div>
        <div class="card panel col-s-12 col-m-4">
            <div class="header-container">
                <div class="title-simple">
                    <span class="display-1">Teacher guide</span>
                </div>
            </div>
            <div class="body-container">
                We know that evaluating student's codes is challenging and consuming. Therefore, the website provide the service to help teachers
                upload problems, so the system can judge student codes automatically.
                This guide-line is provided to help teachers use the system effectively...
            </div>
            <div class="divider"></div>
            <div class="action-container">
                <a href="#" class="flat-button"> more</a>
            </div>
        </div>
        <div class="card panel col-s-12 col-m-4">
            <div class="header-container">
                <div class="title-simple">
                    <span class="display-1">Student guide</span>
                </div>

            </div>
            <div class="body-container">
                If you are a beginner, you should read this guide-line to use the website effectively.
                This guide-line contains information about how to submit your code, the environment the code will run in.
                Also some potential errors are also explained in this guide-line...
            </div>
            <div class="divider"></div>
            <div class="action-container">
                <a href="#" class="flat-button"> more</a>
            </div>
        </div>
        <div class="card panel col-s-12 col-m-4">
            <div class="header-container">
                <div class="title-simple">
                    <span class="display-1">Contact us</span>
                </div>
            </div>
            <div class="body-container">
                If you have any questions or inquires, feel free to contact us via the following phone or email. Working hours from 8am-8pm.
                <br>
                <div >
                    <span style="text-decoration: underline; ">Email:</span>nguyenvu9405@gmail.com<br>
                    <span style="text-decoration: underline; ">Phone:</span>+4490 6450 014 <br>
                    <span style="text-decoration: underline; ">Whatsapp:</span>+447 023 768 <br>
                    <span style="text-decoration: underline; ">Address:</span> 65 Floyd Road, Greenwich<br>
                </div>



            </div>
            <div class="divider"></div>
            <div class="action-container">
                <a href="#" class="flat-button"> more</a>
            </div>
        </div>
    </div>
</div>
<?php

include "footer.php";?>
</body>
