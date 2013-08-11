<?php
// require 'indeed.php';

class ProcedureToJson{

	private $DBH = null;
	//public $pshid = '51735';
	

	function init() {
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
			$this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
			$this->DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
			
			//echo $this->DBH;
			//echo 'DB set and DB error mode set<br>';
		}
		catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

	function get_bestmatch_jobs( $userID_bestmatch) {
		try{
			$sql = "call fillskils.get_bestmatch_jobs (:userID_bestmatch)";
			$stmt_bestmatch = $this->DBH->prepare($sql);
			$stmt_bestmatch->bindParam(':userID_bestmatch', $userID_bestmatch, PDO::PARAM_INT);
			$stmt_bestmatch->execute();
			$results_bestmatch = $stmt_bestmatch->fetchAll();
			$stmt_bestmatch->closeCursor();
			unset($stmt_bestmatch);	
			return $results_bestmatch;
		}
		catch(PDOException $e) {
			echo '<br><b>ah an ERROR: </b>';
			echo $e->getMessage();
		}
	}

	function get_top_missing_skills( $userID_missingskills) {
		echo 'dead3 userid:' . $userID_missingskills;
		$sql = "call fillskils.get_top_missing_skills (:userID_missingskills)";
		$stmt_missingskills = $this->DBH->prepare($sql);
		$stmt_missingskills->bindParam(':userID_missingskills', $userID_missingskills, PDO::PARAM_INT);
		$stmt_missingskills->execute();
		$results_missingskills = $stmt_missingskills->fetchAll();
		echo 'dead4';
		//print_r($results_missingskills);echo "\n"; // all record sets
		//print_r(json_encode($results_missingskills)); echo "\n";
		$stmt_missingskills->closeCursor();
		unset($stmt_missingskills);	
		return $results_missingskills;
	}

	function get_missingskills_job($jobID_missingskills_perjob, $userID_missingskills_perjob) {
		
		
		$sql = "call fillskils.get_missingskills_job (:userID_missingskills_perjob, :jobID_missingskills_perjob)";
		$stmt_missingskills_perjob = $this->DBH->prepare($sql);
		$stmt_missingskills_perjob->bindParam(':userID_missingskills_perjob', $userID_missingskills_perjob, PDO::PARAM_INT);
		$stmt_missingskills_perjob->bindParam(':jobID_missingskills_perjob', $jobID_missingskills_perjob, PDO::PARAM_INT);
		$stmt_missingskills_perjob->execute();
		$results_missingskills_perjob = $stmt_missingskills_perjob->fetchAll();
		//print_r($results_missingskills_perjob);echo "\n"; // all record sets
		//print_r(json_encode($results_missingskills_perjob)); echo "\n";
		$stmt_missingskills_perjob->closeCursor();
		unset($stmt_missingskills_perjob);	
		return $results_missingskills_perjob;
	}

	function get_users_skills($userID_userskills) {
		$sql = "call fillskils.get_users_skills (:userID_userskills)";
		$stmt_usersskills = $this->DBH->prepare($sql);
		$stmt_usersskills->bindParam(':userID_userskills', $userID_userskills, PDO::PARAM_INT);
		$stmt_usersskills->execute();
		$results_userskills = $stmt_usersskills->fetchAll();
		//print_r($results_userskills);echo "\n"; // all record sets
		//print_r(json_encode($results_userskills)); echo "\n";
		$stmt_usersskills->closeCursor();
		unset($stmt_usersskills);	
		return $results_userskills;
	}

	function get_top_courses($userID_topCourses) {
		$sql = "call fillskils.get_top_courses (:userID_topCourses)";
		$stmt_topCourses = $this->DBH->prepare($sql);
		$stmt_topCourses->bindParam(':userID_topCourses', $userID_topCourses, PDO::PARAM_INT);
		$stmt_topCourses->execute();
		$results_topCourses = $stmt_topCourses->fetchAll();
		//print_r($results_topCourses);echo "\n"; // all record sets
		//print_r(json_encode($results_topCourses)); echo "\n";
		$stmt_topCourses->closeCursor();
		unset($stmt_topCourses);	
		return $results_topCourses;
	}

	function get_top_courses_more($userID_topCoursesMore) {
		$sql = "call fillskils.get_top_courses_more (:userID_topCoursesMore)";
		$stmt_topCoursesMore = $this->DBH->prepare($sql);
		$stmt_topCoursesMore->bindParam(':userID_topCoursesMore', $userID_topCoursesMore, PDO::PARAM_INT);
		$stmt_topCoursesMore->execute();
		$results_topCoursesMore = $stmt_topCoursesMore->fetchAll();
		//print_r($results_topCoursesMore);echo "\n"; // all record sets
		//print_r(json_encode($results_topCoursesMore)); echo "\n";
		$stmt_topCoursesMore->closeCursor();
		unset($stmt_topCoursesMore);	
		return $results_topCoursesMore;
	}

}






// try {


// 	//BEST MATCH JOBS
// 	$userID_bestmatch = 1;
// 	$sql = "call fillskils.get_bestmatch_jobs (:userID_bestmatch)";
// 	$stmt_bestmatch = $DBH->prepare($sql);
// 	$stmt_bestmatch->bindParam(':userID_bestmatch', $userID_bestmatch, PDO::PARAM_INT);
// 	$stmt_bestmatch->execute();
// 	$results_bestmatch = $stmt_bestmatch->fetchAll();
// 	//print_r($results_bestmatch);echo "\n"; // all record sets
// 	print_r(json_encode($results_bestmatch)); echo "\n";
// 	$stmt_bestmatch->closeCursor();
// 	unset($stmt_bestmatch);	

// 	//TOP MISSING SKILLS
// 	$userID_missingskills = 1;
// 	$sql = "call fillskils.get_top_missing_skills (:userID_missingskills)";
// 	$stmt_missingskills = $DBH->prepare($sql);
// 	$stmt_missingskills->bindParam(':userID_missingskills', $userID_missingskills, PDO::PARAM_INT);
// 	$stmt_missingskills->execute();
// 	$results_missingskills = $stmt_missingskills->fetchAll();
// 	//print_r($results_missingskills);echo "\n"; // all record sets
// 	print_r(json_encode($results_missingskills)); echo "\n";
// 	$stmt_missingskills->closeCursor();
// 	unset($stmt_missingskills);	

// 	echo '<hr/><br>MISSING SKILLS FOR EACH JOB';
// 	foreach ($results_bestmatch as $selectedjob) {
// 		echo '<br>';
// 		echo($selectedjob[jobid]);
// 		$jobID_missingskills_perjob = $selectedjob[jobid];
// 		$userID_missingskills_perjob = 1;
// 		$sql = "call fillskils.get_missingskills_job (:userID_missingskills_perjob, :jobID_missingskills_perjob)";
// 		$stmt_missingskills_perjob = $DBH->prepare($sql);
// 		$stmt_missingskills_perjob->bindParam(':userID_missingskills_perjob', $userID_missingskills_perjob, PDO::PARAM_INT);
// 		$stmt_missingskills_perjob->bindParam(':jobID_missingskills_perjob', $jobID_missingskills_perjob, PDO::PARAM_INT);
// 		$stmt_missingskills_perjob->execute();
// 		$results_missingskills_perjob = $stmt_missingskills_perjob->fetchAll();
// 		//print_r($results_missingskills_perjob);echo "\n"; // all record sets
// 		print_r(json_encode($results_missingskills_perjob)); echo "\n";
// 		$stmt_missingskills_perjob->closeCursor();
// 		unset($stmt_missingskills_perjob);	
// 	}

// }
// catch(PDOException $e) {
// 	echo '<br><b>ah an ERROR: </b>';
// 	echo $e->getMessage();
// }
?>