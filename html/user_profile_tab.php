<ul class="tab-bar">
    <li>
        <a <?php if ($tab_info["name"]=="inf") echo "class='active'"?> href="/user_profile<?php if ($params["user"]) echo "?user={$params["user"]}"; ?>">Info</a>
    </li>

    <li>
        <a <?php if ($tab_info["name"]=="sta") echo "class='active'"?> href="/user_status<?php if ($params["user"]) echo "?user={$params["user"]}"; ?>">Submission History</a>
    </li>
</ul>