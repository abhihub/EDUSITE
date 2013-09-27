<?php
require("common.php");
if(!empty($_POST)) 
{ 
	 // Ensure that the user has entered a non-empty username 
	if(empty($_POST['email'])) 
	{ 
            // Note that die() is generally a terrible way of handling user errors 
            // like this.  It is much better to display the error with the form 
            // and allow the user to correct their mistake.  However, that is an 
            // exercise for you to implement yourself. 
		die("Please enter a username."); 
	} 
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
	{ 
		die("Invalid E-Mail Address"); 
	} 
	try{
		$DBH = common::getInstance()->getDatabase();

		$email = $_POST['email'];
		$STHEnterBeta = $DBH->prepare("INSERT INTO betarequester (email) values (:email)"); 
		$STHEnterBeta->bindParam(':email', $email);
		$STHEnterBeta->execute();	
	}
	catch (Exception $e) {
		die ('Insert Beta failed: ' . $e->getMessage());
	}
	header("Location: betathanks.html"); 
}
?>