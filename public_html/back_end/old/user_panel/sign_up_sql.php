<?php

include "../user_panel/connect_database.php";
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
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $signUpQueryResult = mysql_query("INSERT INTO users (Email, Password, Nickname) VALUES('".$email."', '".$password_hashed."', '".$nickname."')");
        
        $signInQueryResult = mysql_query("SELECT * FROM users WHERE Email = '".$email."'");
        if(mysql_num_rows($signInQueryResult) == 1)
        {
            $row = mysql_fetch_array($signInQueryResult);
            $hash = $row['Password'];
            if (password_verify($password, $hash))
            {
                $email = $row['Email'];
                $nickname = $row['Nickname'];
                $userID = $row['UserID'];

                $_SESSION['userID'] = $userID;
                $_SESSION['email'] = $email;
                $_SESSION['nickname'] = $nickname;

                $_SESSION['loggedIn'] = 1;
                
                echo "success";
            }
            else {
                echo "invalid_password";
            }
        }
        else {
            echo "user_not_exist";
        }

    }
    else
    {
        echo "user_exist";
    }
}

?>