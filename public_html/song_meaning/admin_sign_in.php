<?php

include "../user_panel/connect_database.php";
session_start();

if (!empty($_POST['password']))
{
    $password = mysql_real_escape_string($_POST['password']);

    if("sameaning" == $password)
    {
        $_SESSION['admin'] = 1;
        
        echo "success";
    }
}

?>