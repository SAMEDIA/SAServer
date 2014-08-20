<?php

include "../user_panel/connect_database.php";
session_start();

if (!empty($_POST['accept'])) {
    $accept = $_POST['accept'];
    
    // deny
    if ($accept == 'false') {
        $submissionID = $_POST['submissionID'];

        // dequeue
        $denyQueryResult = mysql_query("UPDATE song_meaning_queue SET Processed = TRUE WHERE SubmissionID = '".$submissionID."';");
        //var_dump($denyQueryResult);
        // succesfully denied
        if($denyQueryResult == true)
        {
            echo "success";
        }
    } 
    // accept
    else if ($accept == 'true') {
        $submissionID = $_POST['submissionID'];

        // get meaning infomation
        $songQueryResult = mysql_query("SELECT * FROM song_meaning_queue WHERE SubmissionID = '".$submissionID."';");
        //var_dump($songQueryResult);

        $row = mysql_fetch_array($songQueryResult);
        $artist = $row['Artist'];
        $trackname = $row['Trackname'];
        $meaning = $row['Meaning'];
        $userID = $row['UserID'];

        // dequeue
        $queryResult = mysql_query("UPDATE song_meaning_queue SET Processed = TRUE WHERE SubmissionID = '".$submissionID."';");
        if ($queryResult == false) {
            echo "fail";
        }

        $queryResult = mysql_query("SELECT * FROM song_meaning WHERE Artist = '".$artist."' AND Trackname = '".$trackname."'");

        // if meaning already in database, replace it
        if (mysql_num_rows($queryResult) == 1) {
            $queryResult = mysql_query("UPDATE song_meaning SET Meaning = '".$meaning."', UserID = '".$userID."' WHERE Artist = '".$artist."' AND Trackname = '".$trackname."'");
            if ($queryResult == true) {
                echo "success";
            }
        }
        // if not, add it
        else {
            $queryResult = mysql_query("INSERT INTO song_meaning (Artist, Trackname, Meaning, UserID) VALUES ('".$artist."', '".$trackname."', '".$meaning."', '".$userID."');");
            if ($queryResult == true) {
                echo "success";
            }
        }
        
    }
}

?>