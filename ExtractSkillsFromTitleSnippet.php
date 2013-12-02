<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
try{
	$DBH = common::getInstance()->getDatabase();
	//Foreach job
	//Get the related skill
	//Get and split Job title and description
	//Check count of Split items in Skills Table table
	//Add JobsSkills relationship if not exists

	$queryalljobs = "select * from jobs"; 

	$queryhassnippetinskill= "select count(*) from skills ss where ss.name = :skillinsnippetname";
	$stmt_is_a_skill = $DBH->prepare($queryhassnippetinskill);

	$query_getskillid_from_skill= "select ss.id from skills ss where ss.name = :skillinsnippetname";
	$stmt_getskillid_from_skill = $DBH->prepare($query_getskillid_from_skill);

	$stmt = $DBH->prepare($queryalljobs, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

	$jobswithlowcount = array();
	
	echo("Ready for a while");
	while ($row = $stmt->fetch(PDO::FETCH_ORI_NEXT)) {
		//Foreach job,
		echo("<br>START Jobid:" . $row[id]);
		// Check if title contains common job title keywords
		$titlesplit = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $row[jobtitle], -1, PREG_SPLIT_NO_EMPTY);
		$titlesplit = array_unique($titlesplit);
		foreach ($titlesplit as $titleskillname) {
			$stmt_is_a_skill->bindParam(':skillinsnippetname', $titlename, PDO::PARAM_STR);
			$titlename = strtolower($titleskillname);
			$stmt_is_a_skill->execute();
			$hastitle = $stmt_is_a_skill->fetchColumn(0);
			echo "<br>hastitle: " . $titlename . " " . $hastitle;
			if($hastitle > 0)
			{
					//If the skill is in skills table, if not exists create connection in jobsskills table
				$widgetJobs->insert_jobsskill_from_skillname_jobid($titlename, $row[id]);
			}
		}
		
			// If still low count, check if snippet has any skills
		$snippetsplit = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $row[snippet], -1, PREG_SPLIT_NO_EMPTY);
		$snippetsplit = array_unique($snippetsplit);
		foreach ($snippetsplit as $snippetskillname) {
			$stmt_is_a_skill->bindParam(':skillinsnippetname', $snippetskillname, PDO::PARAM_STR);
			$snippetskillname = trim(strtolower($snippetskillname));
			$stmt_is_a_skill->execute();
			$hassnippetinskills = $stmt_is_a_skill->fetchColumn(0);
			echo "<br>hassnippetinskills:'" . $snippetskillname . "'" . $hassnippetinskills;
			if($hassnippetinskills > 0)
			{
						//If the skill is in skills table, create connection in jobsskills table
				$widgetJobs->insert_jobsskill_from_skillname_jobid($snippetskillname, $row[id]);
						//die("SNIPPET - Skillname:". $snippetskillname . " Jobid:" . $row[id]);
			}
		}
		
		
		
	}

	$stmt = null;
	$stmt_is_a_skill = null;
}
catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

?>