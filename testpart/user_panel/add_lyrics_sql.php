<?php

include "connect_database.php";
session_start();

if (!empty($_POST['artist']) && !empty($_POST['song']))
{
    $artist = mysql_real_escape_string($_POST['artist']);
    $song = mysql_real_escape_string($_POST['song']);
    $album = mysql_real_escape_string($_POST['album']);
    $year = mysql_real_escape_string($_POST['year']);
    $genre = mysql_real_escape_string($_POST['genre']);
    $lyrics = mysql_real_escape_string($_POST['lyrics']);
    
    //echo "<p>$artist : $song : $album : $year : $genre : $lyrics</p>";

    
    $signUpQueryResult = mysql_query("INSERT INTO songs (Artist, Name, Album, Year, Genre, Lyrics) VALUES('".$artist."', '".$song."', '".$album."', '".$year."', '".$genre."', '".$lyrics."')");
 
    //var_dump($signUpQueryResult);

    // succesfully signed up
    if($signUpQueryResult == true)
    {
        echo "success";
    }
    
    

}

?>