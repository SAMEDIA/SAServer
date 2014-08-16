<?php

include "../user_panel/connect_database.php";
session_start();

if (!empty($_POST['email']) && !empty($_POST['password']))
{
    $email = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']);
     
    //echo "<p>$username:$password</p>";

    $signInQueryResult = mysql_query("SELECT * FROM users WHERE Email = '".$email."' AND Password = '".$password."'");
     
    //var_dump($signInQueryResult);

    //$num = mysql_num_rows($signInQueryResult);
    //echo "<p>$num</p>";

    if(mysql_num_rows($signInQueryResult) == 1)
    {
        $row = mysql_fetch_array($signInQueryResult);
        $email = $row['Email'];
        $nickname = $row['Nickname'];
        $userID = $row['UserID'];

        $_SESSION['userID'] = $userID;
        $_SESSION['email'] = $email;
        $_SESSION['nickname'] = $nickname;

        $_SESSION['loggedIn'] = 1;
        
        echo "success";
    }
    else
    {
        // check whether user exist
        $userCheckQueryResult = mysql_query("SELECT * FROM users WHERE Email = '".$email."'");

        if (mysql_num_rows($userCheckQueryResult) == 0) {
            echo "user_not_exist";
        } else {
            echo "invalid_password";
        }
    }
}

?>