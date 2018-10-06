<div class="panel card">
    <div class="header-container">
        <div class="title">
            <span>Info</span>
        </div>
    </div>
    <div class="description-container">
        <table>
            <tr>
                <td class="label-normal"><label>Code</label></td>
                <td>
                    <a class="link" href="/problems.php?code=<?php echo $prob->getCode();?>">
                        <?php echo $prob->getCode(); ?>
                    </a>
                </td>
            </tr>

            <tr>
                <td class="label-normal"><label>Time limit</label></td>
                <td><?php echo $prob->getTimeLimit(); ?> s</td>
            </tr>
            <tr>
                <td class="label-normal"><label>Mem limit</label></td>
                <td><?php echo $prob->getMemoryLimit() ?> mb</td>
            </tr>
            <?php
                if ($prob->showSol())
                {
                    ?>
                    <tr>
                        <td class="label-normal">
                            <label>SOLUTION</label>
                        </td>
                        <td>
                            <a class="link" href="<?php
                            echo $prob->getSolutionLink();
                            ?>">
                                Link
                            </a>
                        </td>
                    </tr>
            <?php
                }
            ?>

            <tr>
                <td class="label-normal"><label>Poster</label></td>
                <td>
                    <a class="link" href="/user_profile.php?user=<?php echo $prob->getUploader()->getUsername(); ?>">
                        <?php echo $prob->getUploader()->getUsername(); ?>
                    </a>
                </td>
            </tr>

<!--            <tr>-->
<!--                <td class="label-normal"><label>Posted date</label></td>-->
<!--                <td>--><?php
//                        $date = new DateTime($prob["date"]);
//                        echo $date->format("d-m-Y");
//                    ?>
<!--                </td>-->
<!--            </tr>-->
        </table>
    </div>

</div>