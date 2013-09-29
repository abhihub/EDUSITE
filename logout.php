<?php 

    // First we execute our common code to connection to the database and start the session 
	require("common.php"); 

    // We remove the user's data from the session 

    session_start(); # NOTE THE SESSION START
    $_SESSION = array(); 
    session_unset();
    session_destroy();
    //unset($_SESSION['user']); 

    // We redirect them to the login page 
    header("Location: index.php"); 
    die("Redirecting to: index.php");