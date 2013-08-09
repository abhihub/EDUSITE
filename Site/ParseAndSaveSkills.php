<?php
try{
	try {

		$host = 'localhost';
		$dbname = 'FillSkils';
		$user = 'root';
		$pass = 'root';


  			# MySQL with PDO_MYSQL CREATE DATABASE CONNECTION
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	$text = $_POST[skillstring];
	$splitresults = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $text, -1, PREG_SPLIT_NO_EMPTY);
	$splitresults = array_unique($splitresults);

	// echo count($splitresults);
	echo json_encode($splitresults);

	$TruncateSkills = $DBH->exec('Truncate table usersskills');


	$STHGetSkillIdFromSkills = $DBH->prepare('SELECT id FROM skills WHERE name = :skillname');
	$STHGetSkillIdFromSkills->bindParam(':skillname', $skillname);


	$STHInsertUserSkillRelation = $DBH->prepare("INSERT INTO usersskills (userid, skillid) values (:usersid, :skillid)"); 
	$STHInsertUserSkillRelation->bindParam(':usersid', $usersid);
	$STHInsertUserSkillRelation->bindParam(':skillid', $skillid);
	
	$usersid = 1;
	foreach($splitresults as $splititem)
	{
		//echo $splititem;
		$skillname = $splititem;

		$STHGetSkillIdFromSkills->execute();
		$resultsGetSkillId = $STHGetSkillIdFromSkills->fetch();
		$skillid = $resultsGetSkillId[0];
		// echo $skillid;
		
		$STHInsertUserSkillRelation->execute();	
	}
}
catch (Exception $e) {
	echo 'Insert/Truncate failed: ' . $e->getMessage();
}

?>