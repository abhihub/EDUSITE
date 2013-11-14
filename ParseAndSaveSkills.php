<?php
require("common.php");

try{
	
	$DBH = common::getInstance()->getDatabase();
	$userid = $_SESSION['user']['id'];
	
	$text = $_POST['skillstring'];
	$splitresults = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $text, -1, PREG_SPLIT_NO_EMPTY);
	$splitresults = array_unique($splitresults);

	echo $splitresults;

 	$TruncateSkills="DELETE FROM usersskills WHERE userid =" . $userid;
 	echo $TruncateSkills;
	$numRows=$DBH->exec($TruncateSkills); 
	echo($numRows);

	$STHGetSkillIdFromSkills = $DBH->prepare('SELECT id FROM skills WHERE name = :skillname');
	$STHGetSkillIdFromSkills->bindParam(':skillname', $skillname);
	

	$STHInsertUserSkillRelation = $DBH->prepare("INSERT INTO usersskills (userid, skillid) values (:userid, :skillid)"); 
	$STHInsertUserSkillRelation->bindParam(':userid', $userid);
	$STHInsertUserSkillRelation->bindParam(':skillid', $skillid);
	

	
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