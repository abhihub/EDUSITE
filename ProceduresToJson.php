<?php
require 'common.php';
// require 'indeed.php';

class ProcedureToJson{

	private $DBH = null;

	function init() {
		
		$this->DBH = common::getInstance()->getDatabase();
		
	}

	function get_bestmatch_jobs( $userID_bestmatch) {
		try{
			$sql = "call get_bestmatch_jobs (:userID_bestmatch)";
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

	function insert_new_skill( $skillname) {
		try{
			$sql = "call fillskils.insert_new_skill (:skillname)";
			$stmt_bestmatch = $this->DBH->prepare($sql);
			$stmt_bestmatch->bindParam(':skillname', $skillname, PDO::PARAM_STR);
			$stmt_bestmatch->execute();
			$stmt_bestmatch->closeCursor();
			unset($stmt_bestmatch);	
			return $results_bestmatch;
		}
		catch(PDOException $e) {
			echo '<br><b>ah an ERROR: </b>';
			echo $e->getMessage();
		}
	}

	//CALL fillskils.check_if_is_skill('agile');
	function get_is_valid_skill($skillname){
		try{
			$sql = "CALL fillskils.check_if_is_skill(:skillname)";
			$stmt_isvalidskill  = $this->DBH->prepare($sql);
			$stmt_isvalidskill->bindParam(':skillname', $skillname, PDO::PARAM_STR);
			$stmt_isvalidskill->execute();
			$results_isvalidskill = $stmt_isvalidskill->fetchColumn();
			$stmt_isvalidskill->closeCursor();
			unset($stmt_isvalidskill);	
			
			return $results_isvalidskill;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	function get_top_missing_skills( $userID_missingskills) {
		
		$sql = "call fillskils.get_top_missing_skills (:userID_missingskills)";
		$stmt_missingskills = $this->DBH->prepare($sql);
		$stmt_missingskills->bindParam(':userID_missingskills', $userID_missingskills, PDO::PARAM_INT);
		$stmt_missingskills->execute();
		$results_missingskills = $stmt_missingskills->fetchAll();
		
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

	function get_users_skills_resume($userID_userskills) {
		$sql = "call get_users_skills_resume (:userID_userskills)";
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

	function get_top3_courses_skill($skillName_top3Courses) {
		try{
			$sql = "call fillskils.get_top3_courses_skill (:skillName_top3Courses)";
			$stmt_top3CoursesSkillName = $this->DBH->prepare($sql);
			$stmt_top3CoursesSkillName->bindParam(':skillName_top3Courses', $skillName_top3Courses, PDO::PARAM_INT);
			$stmt_top3CoursesSkillName->execute();
			$results_top3CoursesSkillName = $stmt_top3CoursesSkillName->fetchAll();
			//print_r($results_top3CoursesSkillName);echo "\n"; // all record sets
			//print_r(json_encode($results_top3CoursesSkillName)); echo "\n";
			$stmt_top3CoursesSkillName->closeCursor();
			unset($stmt_top3CoursesSkillName);	
			return $results_top3CoursesSkillName;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	function get_all_skillnames() {
		try{
			$sql = "SELECT name from skills";
			$stmt_getSkillsAll = $this->DBH->prepare($sql);
			$stmt_getSkillsAll->execute();
			$results_SkillsAll = $stmt_getSkillsAll->fetchAll(PDO::FETCH_COLUMN);
			$stmt_getSkillsAll->closeCursor();
			unset($stmt_getSkillsAll);
			return json_encode($results_SkillsAll);
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	

	function get_isbetalinkvalid($beta_loginid){
		try{
			$sql = "SELECT count(*) from betatestuniquekeys where unique_key = :beta_loginid and num_uses < 1";
			$stmt_isValidBetaLink  = $this->DBH->prepare($sql);
			$stmt_isValidBetaLink->bindParam(':beta_loginid', $beta_loginid, PDO::PARAM_STR);
			$stmt_isValidBetaLink->execute();
			$results_isValidBetaLink = $stmt_isValidBetaLink->fetchColumn();
			$stmt_isValidBetaLink->closeCursor();
			unset($stmt_isValidBetaLink);	
			
			return $results_isValidBetaLink == 1;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	function update_betalink($beta_loginid){
		try{
			$sql = "UPDATE  betatestuniquekeys SET  num_uses =  '1' WHERE  unique_key = :beta_loginid";
			$stmt_isValidBetaLink  = $this->DBH->prepare($sql);
			$stmt_isValidBetaLink->bindParam(':beta_loginid', $beta_loginid, PDO::PARAM_STR);
			$stmt_isValidBetaLink->execute();
			$stmt_isValidBetaLink->closeCursor();
			unset($stmt_isValidBetaLink);	
		}
		catch(PDOException $e)
		{
			echo 'Error in update' .$e->getMessage();
		}
	}
	
	function get_skillset_matches($userid) {
		try{
			$sql = "CALL get_skillset_matches (:userid)";
			$stmt_getskillsetmatches = $this->DBH->prepare($sql);
			$stmt_getskillsetmatches->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt_getskillsetmatches->execute();
			$results_skillsetmatches = $stmt_getskillsetmatches->fetchAll();
			$stmt_getskillsetmatches->closeCursor();
			unset($stmt_getskillsetmatches);	
			return $results_skillsetmatches;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function get_topjobs_skillsets($userid) {
		try{
			$sql = "CALL get_topjobs_skillsets";
			$stmt_getskillsetmatches = $this->DBH->prepare($sql);
			//$stmt_getskillsetmatches->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt_getskillsetmatches->execute();
			$results_skillsetmatches = $stmt_getskillsetmatches->fetchAll();
			$stmt_getskillsetmatches->closeCursor();
			unset($stmt_getskillsetmatches);	
			return $results_skillsetmatches;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	function get_missingskills_skillset($userid, $skillsetid) {
		try{
			$sql = "CALL get_missingskills_skillset(:userid, :skillsetid)";
			$stmt_getskillsetmatches = $this->DBH->prepare($sql);
			$stmt_getskillsetmatches->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt_getskillsetmatches->bindParam(':skillsetid', $skillsetid, PDO::PARAM_INT);
			$stmt_getskillsetmatches->execute();
			$results_skillsetmatches = $stmt_getskillsetmatches->fetchAll();
			$stmt_getskillsetmatches->closeCursor();
			unset($stmt_getskillsetmatches);	
			return $results_skillsetmatches;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function get_skillsetid_byname($skillsetname) {
		try{
			$sql = "CALL get_skillsetid_byname(:skillsetname)";
			$stmt_getskillsetmatches = $this->DBH->prepare($sql);
			$stmt_getskillsetmatches->bindParam(':skillsetname', $skillsetname, PDO::PARAM_STR);
			$stmt_getskillsetmatches->execute();
			$results_skillsetmatches = $stmt_getskillsetmatches->fetchColumn();
			$stmt_getskillsetmatches->closeCursor();
			unset($stmt_getskillsetmatches);	
			return $results_skillsetmatches;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function insert_resume_for_user($resumetext, $userid) {
		try{
			$sql = "CALL insert_resume_for_user(:resumetext, :userid)";
			$stmt_insertresumeforuser = $this->DBH->prepare($sql);
			$stmt_insertresumeforuser->bindParam(':resumetext', $resumetext, PDO::PARAM_STR);
			$stmt_insertresumeforuser->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt_insertresumeforuser->execute();
			$stmt_insertresumeforuser->closeCursor();
			unset($stmt_insertresumeforuser);	
			return $results_insertresumeforuser;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function insert_skillsnotfound($skillname, $userid) {
		try{
			$sql = "CALL insert_skillsnotfound(:skillname, :userid); ";
			$stmt_insert_skillsnotfound = $this->DBH->prepare($sql);
			$stmt_insert_skillsnotfound->bindParam(':skillname', $skillname, PDO::PARAM_STR);
			$stmt_insert_skillsnotfound->bindParam(':userid', $userid, PDO::PARAM_INT);
			$stmt_insert_skillsnotfound->execute();
			$stmt_insert_skillsnotfound->closeCursor();
			unset($stmt_insert_skillsnotfound);	
			//return $results_insert_skillsnotfound;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function insert_jobsskill_from_skillname_jobid($skillname, $jobid)
	{
		try{
			$sql = "CALL insert_jobsskill_from_skillname_jobid(:skillname, :jobid); ";
			$stmt_insert_jobsskill_from_skillname_jobid = $this->DBH->prepare($sql);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':skillname', $skillname, PDO::PARAM_STR);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':jobid', $jobid, PDO::PARAM_INT);
			$stmt_insert_jobsskill_from_skillname_jobid->execute();
			$stmt_insert_jobsskill_from_skillname_jobid->closeCursor();
			unset($stmt_insert_jobsskill_from_skillname_jobid);	
			//return $results_insert_skillsnotfound;
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function delete_job($jobid)
	{
		try{
			$sql = "delete from jobs where id = :jobid; ";
			$stmt_delete_job = $this->DBH->prepare($sql);
			$stmt_delete_job->bindParam(':jobid', $jobid, PDO::PARAM_INT);
			$stmt_delete_job->execute();
			$stmt_delete_job->closeCursor();
			unset($stmt_delete_job);	
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	function insert_deleted_jobs($row)
	{
		try{
			$jobid = $row[id];
			$jobtitle = $row[jobtitle];
			$company = $row[company];
			$city = $row[city];
			$state = $row[state];
			$country = $row[country];
			$formattedLocation = $row[formattedLocation];
			$source = $row[source];
			$enddate = $row[enddate];
			$snippet = $row[snippet];
			$url = $row[url];
			$onmousedown = $row[onmousedown];
			$jobkey = $row[jobkey];
			$sponsored = $row[sponsored];
			$expired = $row[expired];
			$formattedLocationFull = $row[formattedLocationFull];
			$formattedRelativeTime = $row[formattedRelativeTime];

			$sql = "CALL insert_deleted_jobs(:old_jobidl,:jobtitlel,:companyl,:cityl,:statel,:countryl,:formattedLocationl,
				:sourcel,:enddatel,:snippetl,:urll,:onmousedownl,:jobkeyl,:sponsoredl,:expiredl,:formattedLocationFulll,:formattedRelativeTimel); ";
			$stmt_insert_jobsskill_from_skillname_jobid = $this->DBH->prepare($sql);

			$stmt_insert_jobsskill_from_skillname_jobid->bindParam('old_jobidl', $jobid);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':jobtitlel', $jobtitle);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':companyl', $company);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':cityl', $city);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':statel', $state);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':countryl', $country);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':formattedLocationl', $formattedLocation);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':sourcel', $source);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':enddatel', $enddate);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':snippetl', $snippet);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':urll', $url);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':onmousedownl', $onmousedown);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':jobkeyl', $jobkey);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':sponsoredl', $sponsored);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':expiredl', $expired);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':formattedLocationFulll', $formattedLocationFull);
			$stmt_insert_jobsskill_from_skillname_jobid->bindParam(':formattedRelativeTimel', $formattedRelativeTime);

			$stmt_insert_jobsskill_from_skillname_jobid->execute();
			$stmt_insert_jobsskill_from_skillname_jobid->closeCursor();
			unset($stmt_insert_jobsskill_from_skillname_jobid);	
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

}

?>