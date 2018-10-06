<body>
<?php

if (!is_numeric(InputGet::get("page"))) $cpage = 1;
else $cpage = intval(InputGet::get("page"));
$num_per_page = 10;
$num_off_set = ($cpage-1)*$num_per_page;


if (InputGet::existField("tags"))
{
    $tags_json = InputGet::get("tags");
    $tags = json_decode($tags_json);

    if ($tags)
    {
        $problems_data= Problem::selectProblemsByTags($tags);
        $num_total = Problem::getProblemsByTagsNumber($tags);
        $total_page = ($num_total-1)/$num_per_page+1;
    }
    else Redirect::to("/problems");
}
else
{
    $problems_data = Problem::selectProblems("",array(),array("code","title"),$num_per_page,$num_off_set);
    $num_total = Problem::getProblemsNumber();
    $total_page = ($num_total-1)/$num_per_page+1;
}

include "header.php";
?>

<div class="content">
    <div class="grid-container">
        <div class="col-s-12 col-m-9" id="main-col">
            <div class="card panel">
                <div class="header-container">
                    <div class="title">
                        <span>Problems</span>
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <th class="label-normal center-col col-2 hidden-s">
                                <label>Date</label>
                            </th>
                            <th class="label-normal center-col col-3 col-md-2">
                                <label>Code</label>
                            </th>
                            <th class="label-normal center-col">
                                <label>Title</label>
                            </th>
<!--                            <th class="label-normal center-col hidden-s">-->
<!--                                <label>Solvers</label>-->
<!--                            </th>-->
                            <?php
                                if ($cuser)
                                {
                                    echo "<th class='label-normal icon-col col-3 col-md-2'>
                                            <label>Status</label>
                                        </th>";
                                }
                            ?>
                        </tr>

                        <?php
                        if ($problems_data)
                        {
                            foreach($problems_data as $prob)
                            {
                                $code = $prob["code"];
                                $title = $prob["title"];
                                $date = new DateTime($prob["date"]);
                                echo "<tr>";

                                echo "  <td class='number-col hidden-s'>
                                        {$date->format('M d, Y')}
                                        </td>
                                        <td class='center-col'><a class='link' href='problems/$code'>$code</a></td>
                                        <td class='center-col'><a class='link' href='problems/$code'>$title</a></td>
                                                                                                                    
                                ";
                                //<td class='number-col hidden-s'>20</td>
                                if ($cuser)
                                {
                                    if ($prob["status"]==200) echo "<td class='icon-col'><i class='material-icons success'>check_box</i></td>";
                                    else echo "<td class='icon-col'><i class='material-icons'>check_box_outline_blank</i></td>";
                                }
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
                <div class="footer-container inner-center">
                    <?php include "pagination.php"; ?>
                </div>
            </div>
        </div>
        <div class="col-s-12 col-m-3">
           <?php include "search_tag_panel.php"; ?>
        </div>
    </div>
</div>

<?php include "footer.php";  ?>
<script src="/Javascript/tags.js"></script>

<script>
    <?php
        foreach ($tags as $tag)
        {
            echo "addTag('$tag');";
        }
    ?>
</script>

</body>
