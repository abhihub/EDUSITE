<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
try{
	$DBH = common::getInstance()->getDatabase();
	//Foreach job
	//Get the skill count
	//If count < 3, Get and split Job title and Snippet
	//Check count of split items in CommonJobTitles table
	//If count < 2, sort and show them in a list

	$query_all_jobsskills = " 
	select jj.id as jjid, jj.jobtitle, jj.`snippet`,  group_concat(ss.name separator ',' ), count(1) as count
	from jobs jj 
	inner join jobsskills js on jj.id = js.jobid
	inner join skills ss on js.skillid = ss.id
	group by jj.id
	"; 
	$queryhastitle = "select count(*) from commonjobtitlekeywords where title = :titlename";
	$stmt_titlematch = $DBH->prepare($queryhastitle);
	
	$queryhassnippetinskill= "select count(*) from skills ss where ss.name = :skillinsnippetname";
	$stmt_snippetmatch = $DBH->prepare($queryhassnippetinskill);

	$stmt_all_jobsskills = $DBH->prepare($query_all_jobsskills, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt_all_jobsskills->execute();

	$jobswithlowcount = array();
	
	while ($row = $stmt_all_jobsskills->fetch(PDO::FETCH_ORI_NEXT)) {
		$matchedskills = "";
		$skillmatchcount = $row[count];	

		//echo("<br><br> ". print_r($row));

		// Check if title contains common job title keywords
		if($skillmatchcount < 3)
		{
			$titlesplit = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $row[jobtitle], -1, PREG_SPLIT_NO_EMPTY);
			$titlesplit = array_unique($titlesplit);
			foreach ($titlesplit as $titleskillname) {
				$stmt_titlematch->bindParam(':titlename', $titlename, PDO::PARAM_STR);
				$titlename = strtolower($titleskillname);
				$stmt_titlematch->execute();
				$hastitle = $stmt_titlematch->fetchColumn(0);
				//echo "<br>hastitle: " . $titlename . " " . $hastitle;
				if($hastitle > 0)
				{
					$skillmatchcount = $skillmatchcount+1;
				}
			}
			// If still low count, check if snippet has common job title keywords
			if($skillmatchcount < 3)
			{
				$snippetsplit = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $row[snippet], -1, PREG_SPLIT_NO_EMPTY);
				$snippetsplit = array_unique($snippetsplit);
				foreach ($snippetsplit as $snippetskillname) {
					$stmt_titlematch->bindParam(':titlename', $titlename, PDO::PARAM_STR);
					$titlename = strtolower($snippetskillname);
					$stmt_titlematch->execute();
					$hastitle = $stmt_titlematch->fetchColumn(0);
					//echo "<br>hastitle: " . $titlename . " " . $hastitle;
					if($hastitle > 0)
					{
						$skillmatchcount = $skillmatchcount+1;
					}					
				}
			}
		}
		if($skillmatchcount <3)
		{
			array_push($jobswithlowcount, $row);
		}
		echo "<br>Jobid:" . $row[jjid] . " Count:" . $skillmatchcount . " " . $matchedskills;
		
	}
	foreach ($jobswithlowcount as $descardedjob) {
		 //Insert into deleted jobs table
		 $widgetJobs->insert_deleted_jobs($descardedjob);
		 //Delete job from jobs table
		 //$widgetJobs->delete_job($descardedjob[jjid]);
		 //echo(print_r($descardedjob[id] . " " . $descardedjob[jobtitle] . " " . $descardedjob[snippet]));
		 echo "<br>";
	} 
	echo count("<br>" .$jobswithlowcount);
	$stmt = null;
	$stmt_titlematch = null;
}
catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

?>