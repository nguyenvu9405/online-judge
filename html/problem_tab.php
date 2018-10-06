<ul class="tab-bar">
    <li>
        <a <?php if ($tab_info["name"]=="def") echo "class='active'"?> href="/problems/<?php echo $params["code"]; ?>">Definition</a>
    </li>
    <li>
        <a <?php if ($tab_info["name"]=="sub") echo "class='active'"?> href="/submit.php?code=<?php echo $params["code"]; ?>">Submit</a>
    </li>
    <?php
    if ($cuser){
        ?>
        <li>
            <a <?php if ($tab_info["name"]=="you") echo "class='active'"?> href="/status.php?code=<?php echo $params["code"]; ?>&user=<?php echo $cuser->getUsername(); ?>">
                Your submissions
                <?php
                    if ($prob->getData("status")=="200")
                    {
                        echo "<i class='material-icons success'>check_box</i>";
                    }
                ?>
            </a>
        </li>
    <?php }
    ?>
    <li>
        <a <?php if ($tab_info["name"]=="sta") echo "class='active'"?> href="/status.php?code=<?php echo $params["code"]; ?>">Status</a>
    </li>
</ul>