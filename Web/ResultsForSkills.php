<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="http://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
</head>
<body>
    <div><label id="naslov"><b></b></label></div>
    <div class="container_12">
        <div class="wrapper pad1">
            <div>
                <ul id="sel">
                    <?php

                    $widgetJobs->init();
                    $results = $widgetJobs->get_bestmatch_jobs('1');
                    //echo($results);
                    //echo 'get_bestmatch_jobs<br>';
                    
                    foreach($results as $result)
                    {
                        //echo $result;
                        echo '
                        <li>
                        <div class="meta"><label class="jobid">' . 
                        $result[jobid] . '</label> - <label>' . $result[numberofskills] . 
                        '</label></div>
                        </li>
                        ';
                    }
                    //echo '</ul>';
                    
                    ?>
                </ul>
            </div>
        </div>
    </div>


    <div class="container_12">
        <div class="wrapper pad1">
            <div>
                <ul class="list2">
                    <?php
                    // $widgetJobs = new ProcedureToJson();
                    //$widgetJobs->init();
                    $results = $widgetJobs->get_top_missing_skills('1');
                    //echo($results);
                    echo 'get_top_missing_skills<br>';
                    echo '<ul class="wpsha-widget-joblist">';
                    foreach($results as $result)
                    {
                        echo $result;
                        echo '
                        <li class="job-item">
                        <div class="meta">' . 
                        $result[numberofskills] . ' - ' . $result[skillname] . ' - ' . $result[jobs] . 
                        '</div>
                        </li>
                        ';
                    }
                    echo '</ul>';

                    ?>
                </ul>
            </div>
        </div>
    </div>


   
    <script type="text/javascript">
    $('#sel li').click(function () {
        console.log($(this).find('.jobid').text());
        $.ajax({ url: 'get_missingskills_job.php',
         // data: {action: 'get_missingskills_job'},
         data: { jobID_missingskills_perjob: $(this).find('.jobid').text() },
         type: 'POST',
         success: function(output) {
                      //alert(output);
                      $('#naslov b').html(output);
                  }
        });
    });
    </script>
</body>
</html>


