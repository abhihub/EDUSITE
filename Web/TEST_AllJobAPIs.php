<?php
include_once ('SimplyHired_API.php');
require 'indeed_API.php';
require 'Careerjet_API.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="http://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>

    <div class="container_12">
        <div class="wrapper pad1">
            <div>
                <h2>Indeed API test</h2>
                <ul class="list2">
                    <?php
                    $client = new Indeed("9373531657488005");
                    $params = array(
                        "q" => "ios",
                        "l" => "Irvine, ca",
                        "radius"=>"30",
                        "limit"=>"100",
                        "userip" => "173.197.64.177",
                        "useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)");
                    
                    $text = file_get_contents('AllSkills.txt', true);
                    $splitresults = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $text, -1, PREG_SPLIT_NO_EMPTY);
                    $splitresults = array_unique($splitresults);
                    
                    echo count($splitresults);
                    echo '<br>';
                    foreach($splitresults as $splititem)
                    {
                        echo $splititem;
                        echo '<br>';
                        
                        $params = array(
                            "q" => $splititem,
                            "l" => "Irvine, ca",
                            "radius"=>"30",
                            "limit"=>"10",
                            "userip" => "173.197.64.177",
                            "useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)");
                        
                        $results = $client->search($params);
                        
                        echo '<ul class="wpsha-widget-joblist">';
                        foreach($results['results'] as $item)
                        {
                                    //echo $item[url];
                            $anchor = 'href="'.$item[url].'" target="_blank" rel="nofollow"';
                            echo '
                            <li class="job-item">
                            <a ' . $anchor . '>' . $item[jobtitle] . '</a>
                            <div class="meta">' . 
                            $item[source] . ' - ' . $item[formattedLocation] . 
                            '</div>
                            <div class="meta">' .
                            $item[snippet] .
                            '</div>
                            </li>
                            ';
                        }
                        echo '</ul>';
                        echo '<br>';
                    }
                    
                    
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
                    $api = new Careerjet_API('en_GB') ;
                            $page = 1 ; # Or from parameters.
                            
                            $result = $api->search(array( 'keywords' => 'apps developer',
                              'location' => 'Irvine, CA',
                              'page' => $page ,
                              'affid' => '585d8295b956dd235d780ec7494ac882',
                              )
                            ) ;
                            
                            if ( $result->type == 'JOBS' ){
                              echo "Found ".$result->hits." jobs" ;
                              echo " on ".$result->pages." pages\n" ;
                              $jobs = $result->jobs ;
                              echo '<ul class="wpsha-widget-joblist">';
                              foreach( $jobs as $job ){
                                $anchor = 'href="'.$job->url.'" target="_blank" rel="nofollow" onMouseDown="xml_sclk(this);"';
                                echo '
                                <li class="job-item">
                                <a ' . $anchor . '>' . $job->title . '</a>
                                <div class="meta">' . 
                                $job->company . ' - ' . $job->locations . 
                                '</div>
                                <div class="meta">' .
                                $job->description .
                                '</div>
                                </li>
                                ';
                                /*echo " URL:     ".$job->url."\n" ;
                                echo " TITLE:   ".$job->title."\n" ;
                                echo " LOC:     ".$job->locations."\n";
                                echo " COMPANY: ".$job->company."\n" ;
                                echo " SALARY:  ".$job->salary."\n" ;
                                echo " DATE:    ".$job->date."\n" ;
                                echo " DESC:    ".$job->description."\n" ;
                                echo "\n" ;*/
                            }
                            echo '</ul>';
                        }
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
                        $client = new Indeed("9373531657488005");
                        $params = array(
                            "q" => "ios",
                            "l" => "91765",
                            "radius"=>"100",
                            "limit"=>"200",
                            "userip" => "173.197.64.177",
                            "useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
                            );

                        $results = $client->search($params);

                        echo '<ul class="wpsha-widget-joblist">';
                        foreach($results['results'] as $item)
                        {
                                //echo $item[url];
                            $anchor = 'href="'.$item[url].'" target="_blank" rel="nofollow"';
                            echo '
                            <li class="job-item">
                            <a ' . $anchor . '>' . $item[jobtitle] . '</a>
                            <div class="meta">' . 
                            $item[source] . ' - ' . $item[formattedLocation] . 
                            '</div>
                            <div class="meta">' .
                            $item[snippet] .
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


        <div class="container_12">
            <div class="wrapper pad1">
                <div>
                    <ul class="list2">
                        <?php
                        $widgetJobs = new SimplyHired_API();
                        $widgetJobs->set_query('ios');
                        $widgetJobs->set_location('91765');
                            //$shJobs->set_radius( $args['radius'] );
                        $results = $widgetJobs->search('10');
                            //var_dump($results);
                            //throw new Exception('Division by zero.');
                        /* Output the page list. */
                        echo 'SIMPLYHIRED';
                        echo '<ul class="wpsha-widget-joblist">';
                        foreach($results->rs->r as $result)
                        {
                            echo $result;
                            $anchor = 'href="'.$result->src['url'].'" target="_blank" rel="nofollow" onMouseDown="xml_sclk(this);"';
                            echo '
                            <li class="job-item">
                            <a ' . $anchor . '>' . $result->jt . '</a>
                            <div class="meta">' . 
                            $result->cn . ' - ' . $result->loc . 
                            '</div>
                            <div class="meta">' .
                            $result->e .
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

    </body>
    </html>


