<?php
try {

	$host = 'localhost';
	$dbname = 'FillSkils';
	$user = 'root';
	$pass = 'root';


  			# MySQL with PDO_MYSQL CREATE DATABASE CONNECTION
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  

			//echo $this->DBH;
			//echo 'DB set and DB error mode set<br>';
}
catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
$userID_missingskills_perjob = 1;
$jobID_missingskills_perjob  = $_POST[jobID_missingskills_perjob];
echo $jobID_missingskills_perjob;
// $jobID_missingskills_perjob = 33;
$sql = "call fillskils.get_missingskills_job (:userID_missingskills_perjob, :jobID_missingskills_perjob)";
$stmt_missingskills_perjob = $DBH->prepare($sql);
$stmt_missingskills_perjob->bindParam(':userID_missingskills_perjob', $userID_missingskills_perjob, PDO::PARAM_INT);
$stmt_missingskills_perjob->bindParam(':jobID_missingskills_perjob', $jobID_missingskills_perjob, PDO::PARAM_INT);
$stmt_missingskills_perjob->execute();
$results_missingskills_perjob = $stmt_missingskills_perjob->fetchAll();
//print_r($results_missingskills_perjob);echo "\n"; // all record sets
// print_r(json_encode($results_missingskills_perjob)); echo "\n";
$stmt_missingskills_perjob->closeCursor();
unset($stmt_missingskills_perjob);	
echo json_encode($results_missingskills_perjob);
?>