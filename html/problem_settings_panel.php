<div class="panel card">
    <div class="header-container space-around">
        <div class="title">
            <span>Settings</span>
        </div>
    </div>
    <div class="divider"></div>
    <div class="vertical-list-container">
        <ul>
            <li class="ver-list-item more-padding-md grey-color <?php if ($prob_setting_tab_info["name"]=="def") echo "active";?>">
                <a href="/problem_edit_def?prob_id=<?php echo $prob->getId();?>">
                    <i class="material-icons grey-color">mode_edit</i>
                    <span>Edit definition</span>
                </a>
            </li>
            <li class="ver-list-item more-padding-md <?php if ($prob_setting_tab_info["name"]=="testdata") echo "active";?>">
                <a href="/problem_edit_testdata.php?prob_id=<?php echo $prob->getId();?>">
                    <i class="material-icons grey-color">attach_file</i>
                    <span>Update testdata</span>
                </a>
            </li>
            <li class="ver-list-item more-padding-md grey-color <?php if ($prob_setting_tab_info["name"]=="cons") echo "active";?>">
                <a href="/problem_edit_cons.php?prob_id=<?php echo $prob->getId();?>">
                    <i class="material-icons grey-color">settings</i>
                    <span>Setting constrants</span>
                </a>
            </li>
            <li class="ver-list-item more-padding-md grey-color <?php if ($prob_setting_tab_info["name"]=="tags") echo "active";?>">
                <a href="/problem_edit_tags.php?prob_id=<?php echo $prob->getId();?>">
                    <i class="material-icons grey-color">playlist_add</i>
                    <span>Update tags</span>
                </a>
            </li>
            <li class="ver-list-item more-padding-md grey-color <?php if ($prob_setting_tab_info["name"]=="sol") echo "active";?>">
                <a href="/problem_edit_solution.php?prob_id=<?php echo $prob->getId();?>">
                    <i class="material-icons grey-color">lightbulb_outline</i>
                    <span>Setting solution</span>
                </a>
            </li>
        </ul>
    </div>
</div>