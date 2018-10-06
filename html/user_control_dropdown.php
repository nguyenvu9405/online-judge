<div class="dropdown-container vertical-list-container" id="user_control_dropdown">
    <ul>
        <li class="ver-list-item">
            <a href="/user_profile.php">
                <i class="material-icons">face</i>
                <span>User profile</span>
            </a>
        </li>
        <?php if ($cuser->canUpload()) { ?>
            <li class="ver-list-item">
                <a href="/upload_problem.php">
                    <i class="material-icons">file_upload</i>
                    <span>Upload problem</span>
                </a>
            </li>
        <?php } ?>
        <li class="ver-list-item">
            <a href="/logout.php?rurl=<?php echo Server::getRequestURI(); ?>">
                <i class="material-icons">exit_to_app</i>
                <span>Log out</span>
            </a>
        </li>
    </ul>
</div>