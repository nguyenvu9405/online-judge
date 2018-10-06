<div id="notification-container">
</div>

<script src="/Javascript/core.js"></script>

<script>
    <?php
        $msg = Session::getFlash();
        if ($msg)
        {
            echo "addNoti(\"{$msg[0]}\",\"{$msg[1]}\",{$msg[2]});";
        }
        $panel_info = Session::flashPanel();
        if ($panel_info)
        {
            echo "addNotiPanel({$panel_info[0]},\"{$panel_info[1]}\");";
        }

    ?>
</script>