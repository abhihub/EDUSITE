<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
try
{
	$DBH = common::getInstance()->getDatabase();
	//Foreach Course
	//Split Name, Description and Skills columns
	//For each split item, if it is a skill, add connection in courses_skills table
	
	$query_is_skill = "select count(*) from skills where name = :skillname";
	$stmt_is_skill = $DBH->prepare($query_is_skill);
	
	$query_all_courses = "select * from courses co"; 
	$stmt_all_courses = $DBH->prepare($query_all_courses, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt_all_courses->execute();

	while ($row_course = $stmt_all_courses->fetch(PDO::FETCH_ORI_NEXT)) 
	{
		//echo("<br><br> ". print_r($row_course));

		$unsplit_all = $row_course[name] . ", " . $row_course[description] . ", " . $row_course[skills];
		$split_all_results = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $unsplit_all, -1, PREG_SPLIT_NO_EMPTY);
		
		$split_all_results = array_unique($split_all_results);
		print_r($split_all_results);
		foreach ($split_all_results as $splited_value) 
		{
			$stmt_is_skill->bindParam(':skillname', $skillname, PDO::PARAM_STR);
			$skillname = strtolower($splited_value);
			$stmt_is_skill->execute();
			$is_skill = $stmt_is_skill->fetchColumn(0);
			echo "<br>is_skill: " . $skillname . " " . $is_skill;
			if($is_skill > 0)
			{
				echo "<br>ID: " . $row_course[id];
				//Insert course_skills connection if not exists	
				$widgetJobs->insert_coursesskill_ifnotexists($skillname, $row_course[id]);			
			}
		}		
	}
}
catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

?>