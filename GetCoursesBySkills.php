<?php
try{
	try {

		$host = 'tunnel.pagodabox.com';
		$dbname = 'DB1';
		$user = 'tambra';
		$pass = 'bg4oBEMO';

		// $host = 'localhost';
		// $dbname = 'FillSkils';
		// $user = 'root';
		// $pass = 'root';

  			# MySQL with PDO_MYSQL CREATE DATABASE CONNECTION
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	$skillname = $_POST['skillstring'];
	//echo "Skillstring: " . $skillname;
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