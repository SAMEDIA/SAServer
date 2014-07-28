<?php

include "connect_database.php";
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

        $_SESSION['Email'] = $email;
        $_SESSION['Nickname'] = $nickname;

        $_SESSION['LoggedIn'] = 1;
        
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