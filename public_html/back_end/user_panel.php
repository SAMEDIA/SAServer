<!-- load jQuery if not available -->
<script>
  window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.11.0.min.js"><\/script>')
</script>
<!-- load CSS -->
<link href="user_panel.css" rel="stylesheet"/>




<?php
// load models
require_once "User.php";

if (!isset($_SESSION)) { session_start(); }

// instantiate user object

//session_destroy();
//session_start();
//$_SESSION['userID'] = 1;
//unset($_SESSION['userID']);

//echo $_SESSION['userID'];
//unset($_SESSION['userID']);

if (!empty($_SESSION['userID'])) {
    
    $user = new User($_SESSION['userID']);

    // user already logged in
    // show brief user information
    // Carmen: please change here for the front-end design
    echo '<p>You have logged in! Nickname : <code>';
    echo $user->getNickname();
    echo '</code> Email : <code>';
    echo $user->getEmail();
    echo '</code> ID : <code>';
    echo $user->getID();
    echo '</code></p>';

    echo '<a href="" id="signOutLink">Sign Out</a>';
    ?>
    

    <script>
    // Ajax Sign Out
    $(document).ready(function(){
        $("#signOutLink").click(function(){
            // will run sign_out procedure and redirect page
            $.post('User_controller.php', {'action':"signOut"}, function(data,status){
                if ("success" == data) {
                    $("head").append('<meta http-equiv="refresh" content="0;../back_end/index_test.php">');    
                }
            });
        });
    });
    </script>

    <?php

}
else {
    // userID not set in SESSION, or userID=0, which is visitor
    $user = new User();
    echo '<p>You are not logged in!</p>';

    ?>

    <!-- Carmen: change here for unlogged user panel UI design -->
    <a href="" data-toggle="modal" data-target="#signInModal">Sign In</a>
    .
    <a href="" data-toggle="modal" data-target="#signUpModal">Sign Up</a>

    <script>
    $(document).ready(function(){
        // Ajax Sign In
        $("#signInButton").click(function(){
            var email = $("#emailSignIn").val();
            var password = $("#passwordSignIn").val();

            //$("#signInResult").text("testing").css("color","green");

            // will run sign_in procedure, check with database, and redirect, or provide information for invalid log in
            $.post('User_controller.php', {'action':'signIn', 'email':email, 'password':password}, function(data){
                if ("success" == data) {
                    $("#signInResult").text("yes! redirecting...").css("color","green");
                    $("head").append('<meta http-equiv="refresh" content="2">');
                } else if ("user_not_exist" == data) {
                    $("#signInResult").text("User not exist!").css("color","red");
                } else if ("invalid_password" == data) {
                    $("#signInResult").text("Invalid password!").css("color","red");
                } else {
                    $("#signInResult").text(data).css("color","red");
                }
            });
        });
        // Ajax Sign Up
        $("#signUpButton").click(function(){
            var email = $("#emailSignUp").val();
            var password = $("#passwordSignUp").val();
            var nickname = $("#nicknameSignUp").val();
            // will sign up and insert new user data into database, or provide information for duplicated email address
            $.post('User_controller.php', {'action':'signUp', 'email':email, 'password':password, 'nickname':nickname}, function(data){
                $("#signUpResult").text(data);
                if (data == "success") {
                    $("#signUpResult").text("signed up! redirecting...").css("color","green");
                    $("head").append('<meta http-equiv="refresh" content="2">');
                } else if (data == "user_email_exist") {
                    $("#signUpResult").text("***user already existed with this email!").css("color","red");
                } else if (data == "user_nickname_exist") {
                    $("#signUpResult").text("***user already existed with this nickname!").css("color","red");
                }
            });
        });
    });
    </script>

    <!-- Carmen: change sign in and sign up pop-up window UI design -->
    <!-- Bootstrap Modal Sign In -->
    <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="signInModalLabel">SongAbout Sign In</h4>
                    <p style="color:gray"> Create playlists of your favorite music albums and artists! </p>
                </div>
                <div class="modal-body">
                    <!-- 
                    <fb:login-button class="facebook_button" scope="public_profile,email" onlogin="checkLoginState();" >Sign in with Facebook</fb:login-button>
                    <h4> - OR - </h4>
                    <a href="login.php"><img src="LoginTwitter.png"/></a> </br>
                    -->
                    <h6>facebook & twitter here</h6>
                    <h4> - OR - </h4>

                    <label for="emailSignIn">Email:</label>
                    <input type="text" placeholder="Email" id="emailSignIn" name="emailSignIn">

                    <label for="passwordSignIn">Password:</label>
                    <input type="password" placeholder="Password" id="passwordSignIn" name="passwordSignIn">
                    
                    <input type="submit" class="btn btn-primary" id="signInButton" value="Sign In" name="submit">
                    <p id="signInResult"></p>
                    
                    <p>Don't have an account? <a href="" data-dismiss="modal" data-toggle="modal" data-target="#signUpModal">Sign Up</a><p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal Sign Up -->
    <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="signUpModalLabel">SongAbout Sign Up</h4>
                    <p style="color:gray"> Create playlists of your favorite music albums and artists! </p>
                </div>
                <div class="modal-body">
                    <h6>facebook & twitter here</h6>
                    <h4> - OR - </h4>


                    <label for="emailSignUp">Email:</label>
                    <input type="text" placeholder="Email" id="emailSignUp" name="emailSignUp">

                    <label for="passwordSignUp">Password:</label>
                    <input type="password" placeholder="Password" id="passwordSignUp" name="passwordSignUp">

                    <label for="nicknameSignUp">Nickname:</label>
                    <input type="text" placeholder="First Name" id="nicknameSignUp" name="nicknameSignUp">

                    
                    <input type="submit" class="btn btn-primary" id="signUpButton" value="Sign Up" name="submit">

                    <button type="button" class="btn btn-default" id="signUpClose" data-dismiss="modal">Close</button>
                    <p id="signUpResult"></p>
                </div>
            </div>
        </div>
    </div>

    <?php
}


?>



