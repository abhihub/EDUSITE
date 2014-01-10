<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();

try
{
	$DBH = common::getInstance()->getDatabase();
	$userid = $_SESSION['user']['id'];
	$targetstring = $_POST['targetstring'];
	
	//$row = $widgetJobs->get_user_goal($userid);

	$DeleteOldUserGoals="DELETE FROM users_goals WHERE userid =" . $userid;
	$numRows=$DBH->exec($DeleteOldUserGoals); 
	
	$Stmt_Insert_UserGoals = $DBH->prepare("INSERT INTO users_goals (userid, goal) values (:userid, :targetstring)"); 
	$Stmt_Insert_UserGoals->bindParam(':userid', $userid);
	$Stmt_Insert_UserGoals->bindParam(':targetstring', $targetstring);
	$Stmt_Insert_UserGoals->execute();	

}
catch (Exception $e) 
{
	echo 'Error: ' . $e->getMessage();
}

?>