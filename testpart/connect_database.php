<?php
 
$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "songabou_sa_production_db"; // the name of the database that you are going to use for this project
$dbuser = "songabout"; // the username that you created, or were given, to access your database
$dbpass = "songabout"; // the password that you created, or were given, to access your database
 
$connection=mysqli_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysqli_error());
mysqli_select_db($connection,$dbname) or die("MySQL Error: " . mysqli_error());

//echo "<p>MySql database connected.</p>";
?>