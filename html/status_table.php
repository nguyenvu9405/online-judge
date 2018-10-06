<?php
$running_ids = array();
?>


<div class="card panel">
    <div class="header-container">
        <div class="title">
            <span>Status</span>
        </div>
    </div>
        <div class="table-container status-table">
            <table>
                <tr>
                    <th class="label-normal number-col id-col">
                        <label>Id</label>
                    </th>
                    <th class="label-normal center-col user-col">
                        <label>User</label>
                    </th>
                    <th class="label-normal center-col problem-col">
                        <label>Problem</label>
                    </th>
                    <th class="label-normal center-col result-col" >
                        <label>Result</label>
                    </th>
                    <th class="label-normal number-col time-col">
                        <label>Time</label>
                    </th>
                    <th class="label-normal number-col mem-col">
                        <label>Mem</label>
                    </th>
                    <th class="label-normal center-col lang-col">
                        <label>Lang</label>
                    </th>
                </tr>
                <?php
                if ($subs)
                {
                    foreach($subs as $sub_data)
                    {
                        $sub = new Submission($sub_data);
                        if ($csub!==false && $csub==$sub->getId())
                            echo "<tr class='active'>";
                        else echo "<tr>";
                        
                        if ($cuser && $cuser->canView($sub))
                        {
                            echo "<td class='center-col id-col'><a class='link sub-link' sub-id='{$sub->getId()}'>{$sub->getId()}</a></td>";
                        }
                        else 
                            echo "<td class='center-col id-col'>{$sub->getId()}</td>";
                        echo "<td class='center-col user-col'><a class='link' href='/user_profile?user={$sub->getSubmitter()->getUsername()}'>{$sub->getSubmitter()->getUsername()}</a></td>
                              <td class='center-col problem-col'><a class='link' href='/problems/{$sub->getProblem()->getCode()}'>{$sub->getProblem()->getCode()}</a></td>
                            ";

                        if ($sub->getStatus()<100)
                        {
                            array_push($running_ids,$sub->getId());
                            echo "<td class='center-col result-col result-cell '>
                                       {$sub->getStatusContent()}
                                  </td>";
                            echo "<td class='center-col time-col' id=\"time_{$sub->getId()}\">{$sub->getTimeInSecs()} s</td>
                                  <td class='center-col mem-col' id=\"mem_{$sub->getId()}\">{$sub->getMemInMb()} mb</td>
                            ";
                        }
                        else
                        {
                            echo "<td class='center-col result-col result-cell'>
                                   <span class='error'>{$sub->getStatusContent()}</span>
                                  </td>
                                ";
                            echo "<td class='center-col time-col'>{$sub->getTimeInSecs()} s</td><td class='center-col mem-col'>{$sub->getMemInMb()} mb</td>";
                        }

                        echo "<td class='center-col lang-col'>{$sub->getLang()}</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
        <div class="footer-container inner-center">
            <div class="pagination">
                <?php
                    include "pagination.php";
                ?>
            </div>
        </div>
</div>

<?php

if ($running_ids)
{
    $str = http_build_query(array("ids"=>$running_ids));
    ?>
    <script>
        var sse = new EventSource("status_update_stream.php?<?php echo $str;?>");
        sse.addEventListener("end",function () {
            sse.close();
        });               
    
        sse.addEventListener("update",function(e){
            //console.log(e.data);
            var data = JSON.parse(e.data);
            for (i=0; i<data.length; i++)
            {
                var row = data[i];
                var resultCell = document.getElementById("result_"+row["id"]);
                if (resultCell.getAttribute("status")==row["status"] && resultCell.getAttribute("test_num"==row["test_num"]))
                    continue;
                var status = parseInt(row["status"],10);
                if (status<100)
                {
                    resultCell.innerHTML = row["msg"];
                }
                else if (status<200)
                {
                    resultCell.innerHTML = row["msg"];   
                    resultCell.className = "error";
                }
                else if (status==200){
                    resultCell.innerHTML = row["msg"];
                    resultCell.className = "accepted";
                    var timeCell = document.getElementById("time_"+row["id"]);
                    var memCell = document.getElementById("mem_"+row["id"]);
                    timeCell.textContent = (row["time"]/1000).toFixed(2)+ " s";
                    memCell.textContent = parseInt(row["mem"]/1024)+ " mb";
                }
                resultCell.setAttribute("status",row["status"]);
                resultCell.setAttribute("test_num",row["test_num"]);
            }
        });
    </script>
    <?php
}
?>
<script src="/ace-builds/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("code-editor");
    editor.setTheme("ace/theme/clouds");
    editor.setReadOnly(true);
    editor.session.setMode("ace/mode/c_cpp");
</script>
</script>
