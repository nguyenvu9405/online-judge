<div class="pagination">
    <?php
    $tmp = $_GET;
    if ($cpage > 1) $prev = Functions::getURLPage($tmp,$cpage-1);
    if ($cpage+1 <= $total_page) $next = Functions::getURLPage($tmp, $cpage+1);
    if (!empty($prev)) echo "<a href='?$prev'><i class=\"material-icons\">keyboard_arrow_left</i></a>";
    else echo "<a class='disable'><i class=\"material-icons\">keyboard_arrow_left</i></a>";
    $l = max(1, $cpage-3);
    $r = min($total_page, $l+6);
    for ($i=$l; $i<=$r; $i++)
    {
        $url= Functions::getURLPage($tmp,$i);
        $active = ($i==$cpage) ? "class='active'":"";
        echo "<a href='?$url' $active>$i</a>";
    }
    if (!empty($next)) echo "<a href='?$next'><i class=\"material-icons\">keyboard_arrow_right</i></a>";
    else echo "<a class='disable'><i class=\"material-icons\">keyboard_arrow_right</i></a>";
    ?>
</div>
