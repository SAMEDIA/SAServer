<?php

include "connect_database.php";
if (!isset($_SESSION)) { session_start(); }


//echo "<p>hello, this is user panel.<br>determine user login status:<br></p>";


if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email']))
{
	// user already logged in
    // show brief user information
    echo '<p>You have logged in! Nickname : <code>';
    echo $_SESSION['Nickname'];
    echo '</code> Email : <code>';
    echo $_SESSION['Email'];
    echo '</code></p>';
    ?>

    
    <a href="" id="signOutLink">Sign Out</a>

    <script>
    $(document).ready(function(){
        $("#signOutLink").click(function(){
            $.post('sign_out.php', function(data,status){
                if (data="success") {
                    $("head").append('<meta http-equiv="refresh" content="2;index_test.php">');    
                }
            });
        });
    });
    </script>

    <?php
}
else
{
	
	?>
    <a href="" data-toggle="modal" data-target="#signInModal">Sign In</a>
    .
    <a href="" data-toggle="modal" data-target="#signUpModal">Sign Up</a>

	<script>
    $(document).ready(function(){
        // Ajax Sign In
        $("#signInButton").click(function(){
            var email = $("#emailSignIn").val();
            var password = $("#passwordSignIn").val();
            $.post('sign_in.php', {'email':email, 'password':password}, function(data){
                if (data == "success") {
                    $("#signInResult").text("yes! redirecting...").css("color","green");
                    $("head").append('<meta http-equiv="refresh" content="2">');
                } else if (data == "user_not_exist") {
                    $("#signInResult").text("User not exist!").css("color","red");
                } else if (data == "invalid_password") {
                    $("#signInResult").text("Invalid password!").css("color","red");
                }
            });
        });
        // Ajax Sign Up
        $("#signUpButton").click(function(){
            var email = $("#emailSignUp").val();
            var password = $("#passwordSignUp").val();
            var nickname = $("#nicknameSignUp").val();
            $.post('sign_up.php', {'email':email, 'password':password, 'nickname':nickname}, function(data){
                $("#signUpResult").text(data);
                if (data == "success") {
                    $("#signUpResult").text("signed up! redirecting...").css("color","green");
                    $("head").append('<meta http-equiv="refresh" content="2">');
                } else if (data == "user_exist") {
                    $("#signUpResult").text("***user already existed!").css("color","red");
                }
            });
        });
    });
    </script>


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