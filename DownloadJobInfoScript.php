<?php
require 'common.php';
echo 'BEGIN JOB LOADER<br/>';
require 'API_Indeed.php';

print_r(PDO::getAvailableDrivers());
try {
	# MySQL with PDO_MYSQL CREATE DATABASE CONNECTION
	$DBH = common::getInstance()->getDatabase(); 

	echo '<br/> Database is set';

	$STHInsertJobs = $DBH->prepare('INSERT INTO jobs (jobtitle, company, city, state, country, formattedLocation, 
		source, enddate, snippet, url, onmousedown, jobkey, sponsored, expired, formattedLocationFull, formattedRelativeTime) 
	values (:jobtitle, :company, :city, :state, :country, :formattedLocation, 
		:source, :enddate, :snippet, :url, :onmousedown, :jobkey, :sponsored, :expired, :formattedLocationFull, :formattedRelativeTime)');


	$STHInsertJobs->bindParam(':jobtitle', $jobtitle);
	$STHInsertJobs->bindParam(':company', $company);
	$STHInsertJobs->bindParam(':city', $city);
	$STHInsertJobs->bindParam(':state', $state);
	$STHInsertJobs->bindParam(':country', $country);
	$STHInsertJobs->bindParam(':formattedLocation', $formattedLocation);
	$STHInsertJobs->bindParam(':source', $source);
	$STHInsertJobs->bindParam(':enddate', $enddate);
	$STHInsertJobs->bindParam(':snippet', $snippet);
	$STHInsertJobs->bindParam(':url', $url);
	$STHInsertJobs->bindParam(':onmousedown', $onmousedown);
	$STHInsertJobs->bindParam(':jobkey', $jobkey);
	$STHInsertJobs->bindParam(':sponsored', $sponsored);
	$STHInsertJobs->bindParam(':expired', $expired);
	$STHInsertJobs->bindParam(':formattedLocationFull', $formattedLocationFull);
	$STHInsertJobs->bindParam(':formattedRelativeTime', $formattedRelativeTime);
	echo 'STHInsertJobs set <br>';
	
	$STHFetchSkills = $DBH->query('SELECT * from skills');
	$STHFetchSkills->setFetchMode(PDO::FETCH_ASSOC); 
	echo 'Setup query fetch skills <br/>';

	$STHFetchJobByTitle = $DBH->prepare('SELECT id FROM jobs WHERE jobkey = :jobkeynow');
	$STHFetchJobByTitle->bindParam(':jobkeynow', $jobkeynow);
	echo 'Setup query jobbytitle <br/>';

	$STHInsertJobSkillRelation = $DBH->prepare("INSERT INTO jobsskills (jobid, skillid) values (:jobid, :skillid)"); 
	$STHInsertJobSkillRelation->bindParam(':jobid', $jobid);
	$STHInsertJobSkillRelation->bindParam(':skillid', $skillid);
	echo 'Setup query Insert into Jobskills <br/>';
	echo 'Setup all queries<br/>';

	//Loop through all the skills in the skills table
	while($row = $STHFetchSkills->fetch()) {  

		$fetchedskillname = $row['name'];
		$fetchedskillid = $row['id'];
		echo $fetchedskillname;  
		echo '<br/>';
		$client = new Indeed("9373531657488005");
		$location = '';
		for ($i=0; $i < 3; $i++) { 
			# code...
			if($i==0)
			{
				$location = "Irvine";
				$params = array(
					"q" => $fetchedskillname,
					"l" => "irvine, ca",
					"radius"=>"25",
					"limit"=>"25",
					// "userip" => "173.197.64.177",
					"userip"=> $_SERVER['REMOTE_ADDR'],
					"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
					);
			}
			if($i==1)
			{
				$location = "Pasadena";
				$params = array(
					"q" => $fetchedskillname,
					"l" => "pasadena, ca",
					"radius"=>"25",
					"limit"=>"25",
					"userip" => $_SERVER['REMOTE_ADDR'],
					"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
					);
			}
			if($i==2)
			{
				$location = "Santa Monica";
				$params = array(
					"q" => $fetchedskillname,
					"l" => "santa monica, ca",
					"radius"=>"25",
					"limit"=>"25",
					"userip" => $_SERVER['REMOTE_ADDR'],
					"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
					);
			}




		echo 'Search INDEED.COM for '. $fetchedskillname . ' in ' . $location . '<br/>';
		$results = $client->search($params); //Find out all jobs in LOCATION for that skill
		echo($results);

		foreach($results['results'] as $item)
		{
			$jobkeynow = $item[jobkey];
			$STHFetchJobByTitle->execute();
			$row = $STHFetchJobByTitle->fetch();
			
			echo 'got FetchJobByTitle results <br>';
			if(empty($row) == true) //If job does not exist in the jobs table, then add it along with the skill relation
			{
				echo 'Row is empty <br>';
				$jobtitle = $item[jobtitle];
				$company = $item[company];
				$city = $item[city];
				$state = $item[state];
				$country = $item[country];
				$formattedLocation= $item[formattedLocation];
				$source= $item[source];
				$enddate= $item[date];
				$snippet= $item[snippet];
				$url= $item[url];
				$onmousedown = $item[onmousedown];
				$jobkey= $jobkeynow;
				$sponsored= $item[sponsored];
				$expired= $item[expired];
				$formattedLocationFull= $item[formattedLocationFull];
				$formattedRelativeTime= $item[formattedRelativeTime];

				$STHInsertJobs->execute(); // Job created
				echo 'Insert made for NEW row <br/>';

				//Now insert jobsskills relationship
				$jobid = $DBH->lastInsertId();
				$skillid = $fetchedskillid;
				$STHInsertJobSkillRelation->execute();
				echo 'Added RELATION in jobsskills for NEW job <br/>';

			}
			else //If the Job already exists in jobs table, then find out if this relation already exists, if not add relation
			{
				echo 'reaching else <br/>';

				$STHGetJobIdFromKey = $DBH->prepare('SELECT id FROM jobs WHERE jobkey = :jobkey');
				$STHGetJobIdFromKey->bindParam(':jobkey', $jobkeynow);
				$STHGetJobIdFromKey->execute();
				$resultGetJobIdFromKey = $STHGetJobIdFromKey->fetch();
				$jobidnow = $resultGetJobIdFromKey[0];

				//Query if skillid/jobid relationship already exists
				$STHCheckJobSkillCombo = $DBH->prepare('SELECT id FROM jobsskills WHERE jobid = :jobidnow and skillid	= :skillidnow');
				$STHCheckJobSkillCombo->bindParam(':jobidnow', $jobidnow);
				$STHCheckJobSkillCombo->bindParam(':skillidnow', $fetchedskillid);
				$STHCheckJobSkillCombo->execute();
				$resultjobskillcomboid = $STHCheckJobSkillCombo->fetch();

				echo 'checking to see if jobs - skills combo exists <br/>';
				if($resultjobskillcomboid != true)
				{
					//Insert 
					$jobid = $jobidnow;
					$skillid = $fetchedskillid;
					$STHInsertJobSkillRelation->execute();
					echo 'Insert made jobs-skills for EXISTING row <br/>';

				}
				else
				{
					//Dont do anything, get out
					echo('Dont do anything, get out');
				}
			}
		}
	}
}  



echo '<br/>Good job we are DONE<br/>';

}
catch(PDOException $e) {
	echo 'ERROR: ERROR: ah NO CONNECTION';
	echo $e->getMessage();
}



// $client = new Indeed("9373531657488005");
	// $params = array(
	// 	"q" => "ios",
	// 	"l" => "irvine, ca",
	// 	"radius"=>"50",
	// 	"limit"=>"10",
	// 	"userip" => "173.197.64.177",
	// 	"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
	// 	);

	// echo 'ready to search INDEED';
	// $results = $client->search($params);
	// echo '<br>'. $results . '<br>';

	// foreach($results['results'] as $item)
	// {
	// 	echo 'Inside results loop <br>';
	// 	echo $item[jobtitle];
	// 	$jobtitle = $item[jobtitle];
	// 	$company = $item[company];
	// 	$city = $item[city];
	// 	$state = $item[state];
	// 	$country = $item[country];
	// 	$formattedLocation= $item[formattedLocation];
	// 	$source= $item[source];
	// 	$enddate= $item[date];
	// 	$snippet= $item[snippet];
	// 	$url= $item[url];
	// 	$onmousedown = $item[onmousedown];
	// 	$jobkey= $item[jobkey];
	// 	$sponsored= $item[sponsored];
	// 	$expired= $item[expired];
	// 	$formattedLocationFull= $item[formattedLocationFull];
	// 	$formattedRelativeTime= $item[formattedRelativeTime];

	// 	$STHInsertJobs->execute();
	// }
?>

