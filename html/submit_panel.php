<div class="panel card">
    <div class="header-container">
        <div class="flex-container">
            <div class="title item" style="flex-grow: 1;">
                <span>Submit</span>
            </div>
            <?php
                if ($cuser){
                    ?>
                    <select class="item" name="lang_id" form="problem-submit-form-2">
                        <?php
                        echo Lang::getLangsOptions($cuser->getLatestLangId());
                        ?>
                    </select>
            <?php
                }
            ?>
        </div>
    </div>
        <?php
            if ($cuser) {
                ?>
                <div class="body-container">
                    <form action="/submit.php?code=<?php echo $prob->getCode();?>" method="post" id="problem-submit-form-2" enctype="multipart/form-data">
                            <div class="input-field item last-right" style="max-width: ;">
                                <div class="label">
                                    <label for="code">solution</label>
                                </div>
                                <input type="hidden" name="problem_id" value="<?php echo $prob->getId(); ?>">
                                <input type="file" value="choose" name="submission" required>
                            </div>
                    </form>
                </div>
                <div class="footer-container">
                        <input type="submit" class="raise-button" value="submit" form="problem-submit-form-2">
                </div>
                <?php
            }
            else {
                ?>
                <div class="body-container">
                    You need to log in first to submit your solution. Or you can register an account if you haven't registered yet.
                </div>
                <div class="footer-container">
                    <a class="raise-button" href="/login.php">Sign in</a>
                </div>

                <?php
            }
            ?>

</div>