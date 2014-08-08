<?php

include "../user_panel/connect_database.php";
session_start();

if (!empty($_POST['songID']) && !empty($_POST['meaning']) && !empty($_POST['userID']))
{
    $songID = mysql_real_escape_string($_POST['songID']);
    $meaning = mysql_real_escape_string($_POST['meaning']);
    $userID = mysql_real_escape_string($_POST['userID']);

    //echo "<p>$songID:$meaning:$userID</p>";

    $submitQueryResult = mysql_query("INSERT INTO song_meaning_queue (SongID, Meaning, UserID) VALUES('".$songID."', '".$meaning."', '".$userID."')");

    // succesfully submitted
    if($submitQueryResult == true)
    {
        echo "success";
    }
    
}

?>