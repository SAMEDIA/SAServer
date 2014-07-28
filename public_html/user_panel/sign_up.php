<?php

include "connect_database.php";
session_start();

if (!empty($_POST['email']) && !empty($_POST['password']))
{
    $email = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']);
    $nickname = mysql_real_escape_string($_POST['nickname']);
     
    //echo "<p>$email:$password</p>";

    // check whether user already exists
    $userCheckQueryResult = mysql_query("SELECT * FROM users WHERE Email = '".$email."'");

    // if not exist, insert into table
    if (mysql_num_rows($userCheckQueryResult) == 0) {
        $signUpQueryResult = mysql_query("INSERT INTO users (Email, Password, Nickname) VALUES('".$email."', '".$password."', '".$nickname."')");
     
        //var_dump($signUpQueryResult);

        // succesfully signed up
        if($signUpQueryResult == true)
        {
            $_SESSION['Email'] = $email;
            $_SESSION['Nickname'] = $nickname;

            $_SESSION['LoggedIn'] = 1;
            
            echo "success";
        }
    }
    else
    {
        echo "user_exist";
    }
}

?>