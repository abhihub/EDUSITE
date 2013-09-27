<?php

class common {

	private static $instance;

	public static function getInstance() {

		if (!isset(self::$instance)) {
			self::$instance = new Databasesetup();
		}

		return self::$instance;
	}


	
}

class Databasesetup {
	private $DBH = null;

	function getDatabase()
	{

		if($this->DBH === NULL)
		{

			$this->DBH = $this->setupdatabase();

		}
		return $this->DBH;
	}

	private function setupdatabase(){

			// $host = 'tunnel.pagodabox.com';
			// $dbname = 'DB1';
			// $user = 'tambra';
			// $pass = 'bg4oBEMO';

		$host = 'localhost';
		$dbname = 'FillSkils';
		$user = 'root';
		$pass = 'root';
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 

		try {

			# MySQL with PDO_MYSQL CREATE DATABASE CONNECTION
			$this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		}
		catch (PDOException $e) {
			die('Connection failed: ' . $e->getMessage());
		}

		// This statement configures PDO to throw an exception when it encounters 
    // an error.  This allows us to use try/catch blocks to trap database errors. 
		$this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    // This statement configures PDO to return database rows from your database using an associative 
    // array.  This means the array will have string indexes, where the string value 
    // represents the name of the column in your database. 
	//$this->DBH->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 

    // This block of code is used to undo magic quotes.  Magic quotes are a terrible 
    // feature that was removed from PHP as of PHP 5.4.  However, older installations 
    // of PHP may still have magic quotes enabled and this code is necessary to 
    // prevent them from causing problems.  For more information on magic quotes: 
    // http://php.net/manual/en/security.magicquotes.php 
		if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
		{ 
			function undo_magic_quotes_gpc(&$array) 
			{ 
				foreach($array as &$value) 
				{ 
					if(is_array($value)) 
					{ 
						undo_magic_quotes_gpc($value); 
					} 
					else 
					{ 
						$value = stripslashes($value); 
					} 
				} 
			} 

			undo_magic_quotes_gpc($_POST); 
			undo_magic_quotes_gpc($_GET); 
			undo_magic_quotes_gpc($_COOKIE); 
		} 

    // This tells the web browser that your content is encoded using UTF-8 
    // and that it should submit content back to you using UTF-8 
		header('Content-Type: text/html; charset=utf-8'); 

    // This initializes a session.  Sessions are used to store information about 
    // a visitor from one web page visit to the next.  Unlike a cookie, the information is 
    // stored on the server-side and cannot be modified by the visitor.  However, 
    // note that in most cases sessions do still use cookies and require the visitor 
    // to have cookies enabled.  For more information about sessions: 
    // http://us.php.net/manual/en/book.session.php 
		session_start(); 

		return $this->DBH;
	}
}

