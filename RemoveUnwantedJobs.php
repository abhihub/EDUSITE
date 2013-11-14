<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
try{
	$DBH = common::getInstance()->getDatabase();
	//Foreach job
	//Get the related skill
	//Get and split Job title and description
	//Check count of Split items in Skills Table or JobTitles table
	//If count < 4, sort and show them in a list

	$query = " 
	select jj.id, jj.jobtitle, jj.snippet,  group_concat(ss.name separator ',' ), count(1) as count
	from jobs jj 
	inner join jobsskills js on jj.id = js.jobid
	inner join skills ss on js.skillid = ss.id
	group by jj.id
	"; 
	$queryhastitle = "select count(*) from commonjobtitlekeywords where title = :titlename";
	$stmt_titlematch = $DBH->prepare($queryhastitle);
	
	$queryhassnippetinskill= "select count(*) from skills ss where ss.name = :skillinsnippetname";
	$stmt_snippetmatch = $DBH->prepare($queryhassnippetinskill);

	$stmt = $DBH->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
// array_push($cart, 13);
	$jobswithlowcount = array();
	
	while ($row = $stmt->fetch(PDO::FETCH_ORI_NEXT)) {
		
		$skillmatchcount = $row[count];	
		// Check if title matches common titles
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
			// If still low count, check if snippet has title
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
			// If still low count, check if snippet has skills
			if($skillmatchcount < 3)
			{
				$snippetsplit = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $row[snippet], -1, PREG_SPLIT_NO_EMPTY);
				$snippetsplit = array_unique($snippetsplit);
				foreach ($snippetsplit as $snippetskillname) {
					$stmt_snippetmatch->bindParam(':skillinsnippetname', $snippetskillname, PDO::PARAM_STR);
					$snippetskillname = trim(strtolower($snippetskillname));
					$stmt_snippetmatch->execute();
					$hassnippetinskills = $stmt_snippetmatch->fetchColumn(0);
					echo "<br>hassnippetinskills:'" . $snippetskillname . "'" . $hassnippetinskills;
					if($hassnippetinskills > 0)
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
		
	}
	foreach ($jobswithlowcount as $descardedjob) {
		print_r($descardedjob);
		echo "<br><br>";
	} 
	echo count($jobswithlowcount);
	$stmt = null;
	$stmt_titlematch = null;
}
catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

?>