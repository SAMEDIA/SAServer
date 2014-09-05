<!DOCTYPE html>

<html>
<head>
<title>Test Song Meaning Panel</title>
<meta charset="UTF-8">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
		
<header>
	<h1>SONGABOUT</h1>

<?php

include "../user_panel/connect_database.php";
if (!isset($_SESSION)) { session_start(); }


if (!empty($_SESSION['admin']))
{
	// admin already logged in
    ?>

	<script>
    $(document).ready(function(){
        // Ajax Admin Sign Out
        $("#adminSignOut").click(function(){
            var password = $("#password").val();
            $.post('../user_panel/sign_out.php', {'password':password}, function(data){
                if (data == "success") {
                    $("head").append('<meta http-equiv="refresh" content="0">');
                }
            });
        });
        // Ajax Deny Submission
        // Ajax Accept Submission
        $(".accept").click(function(){
            var submissionID = $(this).parent().attr("id");
            $.post('../song_meaning/song_meaning_verification_sql.php', {'accept':'true', 'submissionID':submissionID}, function(data){
                $('#test').append(data);
                if (data == "success") {
                	$("#test").text("accepted:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });
        // Ajax Deny Submission
        $(".deny").click(function(){
        	var submissionID = $(this).parent().attr("id");
            $.post('../song_meaning/song_meaning_verification_sql.php', {'accept':'false', 'submissionID':submissionID}, function(data){
                if (data == "success") {
                	$("#test").text("denied:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });

    });
    </script>

    <p>You have logged in as admin!</p>
                    
    <input type="submit" class="btn btn-primary" id="adminSignOut" value="Admin Sign Out" name="submit">
    
    <p id="test"></p>
    <table width="900">
    	<tr>
    		<th width="150"></th>
			<th width="70">Artist</th>
			<th width="70">Song</th>
			<th width="300">Meaning</th>
			<th width="70">User ID</th>
			<th width="200">Time Stamp</th>
		</tr>
		
    	<?php
    	// display all the to-be-verified meaning here
		$meaningQueryResult = mysql_query("SELECT * FROM song_meaning_queue WHERE Processed = FALSE ORDER BY SubmissionID ASC");
		

		while ($row = mysql_fetch_array($meaningQueryResult, MYSQL_ASSOC)) {
			echo "<tr>";
			echo '<td><div id="'.$row['SubmissionID'].'"><button class="btn btn-success accept">Accept</button><button class="btn btn-danger deny">Deny</button></div></td>';
			echo "<td>".$row['Artist']."</td>";
            echo "<td>".$row['Trackname']."</td>";
			echo "<td>".$row['Meaning']."</td>";
			echo "<td>".$row['UserID']."</td>";
			echo "<td>".$row['TimeStamp']."</td>";
			echo "</tr>";

		}
		
		

    	?>
	</table>
    <?php
}
else
{
	// admin not logged in
	?>

	<script>
    $(document).ready(function(){
        // Ajax Admin Sign In
        $("#adminSignIn").click(function(){
            var password = $("#password").val();
            $.post('../song_meaning/admin_sign_in.php', {'password':password}, function(data){
                if (data == "success") {
                    $("#signInResult").text("admin logged in! redirecting...").css("color","green");
                    $("head").append('<meta http-equiv="refresh" content="1">');
                } else {
                    $("#signInResult").text("Invalid admin password!").css("color","red");
                }
            });
        });
    });
    </script>

    <label for="password">Password:</label>
    <input type="password" placeholder="Password" id="password" name="password">
                    
    <input type="submit" class="btn btn-primary" id="adminSignIn" value="Admin Sign In" name="submit">
    <p id="signInResult"></p>

    <?php


    
}



?>

</header>

</body>
</html>