<?php

class SADatabase {
	private static $dbserver = "localhost"; // this will ususally be 'localhost', but can sometimes differ
	private static $dbuser = "songabout"; // the username that you created, or were given, to access your database
	private static $dbpass = "123"; // the password that you created, or were given, to access your database
	private static $dbname = "songabout"; // the name of the database that you are going to use for this project

	private static $conn = NULL;
	
	public static function connect() {
		mysql_connect(SADatabase::$dbserver, SADatabase::$dbuser, SADatabase::$dbpass) or die("MySQL Error: " . mysql_error());
		mysql_select_db(SADatabase::$dbname) or die("MySQL Error: " . mysql_error());
	}

	public static function disconnect() {
		
	}
	
	public static function getConnection() {
		if (SADatabase::$conn == NULL) {
			SADatabase::$conn = new mysqli(SADatabase::$dbserver, SADatabase::$dbuser, SADatabase::$dbpass, SADatabase::$dbname);
		}
		
		return SADatabase::$conn;
	}
}

 



?>