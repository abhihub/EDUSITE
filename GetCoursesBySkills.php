<?php
try{
	require("common.php");
	
	$DBH = common::getInstance()->getDatabase();
	$skillname = $_POST['skillstring'];
	
	$STHGetCoursesBySkillName = $DBH->prepare('select cc.* from courses cc inner join coursesskills csk on cc.id = csk.courseid
		inner join skills sk on csk.skillid = sk.id
		where sk.name = :skillname');
	$STHGetCoursesBySkillName->bindParam(':skillname', $skillname);
	$STHGetCoursesBySkillName->execute();
	$resultsCourses = $STHGetCoursesBySkillName->fetchAll();
	$STHGetCoursesBySkillName->closeCursor();
	unset($STHGetCoursesBySkillName);	
	echo json_encode($resultsCourses);
}
catch (Exception $e) {
	echo 'Get Courses By Skills failed: ' . $e->getMessage();
}

?>