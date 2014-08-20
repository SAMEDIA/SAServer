<?php

include "../user_panel/connect_database.php";
session_start();

if (!empty($_POST['artist']) && !empty($_POST['trackname']) && !empty($_POST['meaning']) && !empty($_POST['userID']))
{
    $artist = $_POST['artist'];
    $trackname = $_POST['trackname'];
    $meaning = $_POST['meaning'];
    $userID = $_POST['userID'];

    $artist = strtolower(str_replace(" ","+",$artist));
    $trackname = strtolower(str_replace(" ","+",$trackname));

    //echo "<p>$songID:$meaning:$userID</p>";

    $submitQueryResult = mysql_query("INSERT INTO song_meaning_queue (Artist, Trackname, Meaning, UserID) VALUES('".$artist."', '".$trackname."', '".$meaning."', '".$userID."')");

    // succesfully submitted
    if($submitQueryResult == true)
    {
        echo "success";
    }
    echo "test";
    
}
echo "test";
?>