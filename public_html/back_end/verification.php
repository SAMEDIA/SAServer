<!DOCTYPE html>

<html>
<head>
<title>Verification</title>
<meta charset="UTF-8">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
		
<header>
	<h1>SONGABOUT</h1>

<?php

include "SADatabase.php";
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
            $.post('SongInfo_controller.php', {'action':'adminSignOut'}, function(data){
//                $("#test").text(data);
                if (data == "success") {
                    $("head").append('<meta http-equiv="refresh" content="0">');
                }
            });
        });
        // Ajax Accept Info Submission
        $(".acceptInfo").click(function(){
            var submissionID = $(this).parent().attr("id");
            $.post('SongInfo_controller.php', {'action':'verifyInfo', 'accept':'true', 'submissionID':submissionID}, function(data){
                $('#test').append(data);
                if (data == "success") {
                	$("#test").text("accepted:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });
        // Ajax Deny Info Submission
        $(".denyInfo").click(function(){
        	var submissionID = $(this).parent().attr("id");
            $.post('SongInfo_controller.php', {'action':'verifyInfo', 'accept':'false', 'submissionID':submissionID}, function(data){
                if (data == "success") {
                	$("#test").text("denied:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
                else $("#test").text(data);
            });
        });

        /*
        // Ajax Accept Lyrics Submission
        $(".acceptLyrics").click(function(){
            var submissionID = $(this).parent().attr("id");
            $.post('SongInfo_controller.php', {'action':'verifyInfo', 'accept':'true', 'submissionID':submissionID}, function(data){
                $('#test').append(data);
                if (data == "success") {
                    $("#test").text("accepted:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });
        // Ajax Deny Lyrics Submission
        $(".denyLyrics").click(function(){
            var submissionID = $(this).parent().attr("id");
            $.post('SongInfo_controller.php', {'action':'verifyInfo', 'accept':'false', 'submissionID':submissionID}, function(data){
                if (data == "success") {
                    $("#test").text("denied:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });

        // Ajax Accept Image Submission
        $(".acceptImage").click(function(){
            var submissionID = $(this).parent().attr("id");
            $.post('SongInfo_controller.php', {'action':'verifyInfo', 'accept':'true', 'submissionID':submissionID}, function(data){
                $('#test').append(data);
                if (data == "success") {
                    $("#test").text("accepted:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });
        // Ajax Deny Image Submission
        $(".denyImage").click(function(){
            var submissionID = $(this).parent().attr("id");
            $.post('SongInfo_controller.php', {'action':'verifyInfo', 'accept':'false', 'submissionID':submissionID}, function(data){
                if (data == "success") {
                    $("#test").text("denied:"+submissionID);
                    $("head").append('<meta http-equiv="refresh" content="1">');
                }
            });
        });
        */
    });
    </script>

    <p>You have logged in as admin!</p>
                    
    <input type="submit" class="btn btn-primary" id="adminSignOut" value="Admin Sign Out" name="submit">
    
    <p id="test"></p>

    <h2>Meanings</h2>
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
        $conn = SADatabase::getConnection();
        $sql = 'SELECT * FROM song_info_verification_queue WHERE processed = FALSE AND info_type = "meaning" ORDER BY submission_id ASC';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $queryResult = $stmt->get_result();
        while ($row = $queryResult->fetch_array()) {
            echo "<tr>";
            echo '<td><div id="'.$row['submission_id'].'"><button class="btn btn-success acceptInfo">Accept</button><button class="btn btn-danger denyInfo">Deny</button></div></td>';
            echo "<td>".$row['artist']."</td>";
            echo "<td>".$row['trackname']."</td>";
            echo "<td>".$row['info']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['submission_time']."</td>";
            echo "</tr>";
        }

    	?>
	</table>

    <h2>Video Link</h2>
    <table width="900">
        <tr>
            <th width="150"></th>
            <th width="70">Artist</th>
            <th width="70">Song</th>
            <th width="300">Link</th>
            <th width="70">User ID</th>
            <th width="200">Time Stamp</th>
        </tr>
        
        <?php
        // display all the to-be-verified meaning here
        $conn = SADatabase::getConnection();
        $sql = 'SELECT * FROM song_info_verification_queue WHERE processed = FALSE AND info_type = "video_link" ORDER BY submission_id ASC';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $queryResult = $stmt->get_result();
        while ($row = $queryResult->fetch_array()) {
            echo "<tr>";
            echo '<td><div id="'.$row['submission_id'].'"><button class="btn btn-success acceptInfo">Accept</button><button class="btn btn-danger denyInfo">Deny</button></div></td>';
            echo "<td>".$row['artist']."</td>";
            echo "<td>".$row['trackname']."</td>";
            echo "<td>".$row['info']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['submission_time']."</td>";
            echo "</tr>";
        }

        ?>
    </table>

    <h2>Lyrics</h2>
    <table width="900">
        <tr>
            <th width="150"></th>
            <th width="70">Artist</th>
            <th width="70">Song</th>
            <th width="300">Lyrics</th>
            <th width="70">User ID</th>
            <th width="200">Time Stamp</th>
        </tr>
        
        <?php
        // display all the to-be-verified lyrics here
        $conn = SADatabase::getConnection();
        $stmt = $conn->prepare('SELECT * FROM song_info_verification_queue WHERE processed = FALSE AND info_type = "lyrics" ORDER BY submission_id ASC');
        $stmt->execute();
        $queryResult = $stmt->get_result();
        while ($row = $queryResult->fetch_array()) {
            echo "<tr>";
            echo '<td><div id="'.$row['submission_id'].'"><button class="btn btn-success acceptInfo">Accept</button><button class="btn btn-danger denyInfo">Deny</button></div></td>';
            echo "<td>".$row['artist']."</td>";
            echo "<td>".$row['trackname']."</td>";
            echo "<td>".$row['info']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['submission_time']."</td>";
            echo "</tr>";
        }
        

        ?>
    </table>

    <h2>Images</h2>
    <table width="900">
        <tr>
            <th width="150"></th>
            <th width="70">Artist</th>
            <th width="70">Song</th>
            <th width="300">Image File</th>
            <th width="70">User ID</th>
            <th width="200">Time Stamp</th>
        </tr>
        
        <?php
        // display all the to-be-verified images here
        $imagePath = "images/";
        $conn = SADatabase::getConnection();
        $stmt = $conn->prepare('SELECT * FROM song_info_verification_queue WHERE processed = FALSE AND info_type = "image" ORDER BY submission_id ASC');
        $stmt->execute();
        $queryResult = $stmt->get_result();
        while ($row = $queryResult->fetch_array()) {
            echo "<tr>";
            echo '<td><div id="'.$row['submission_id'].'"><button class="btn btn-success acceptInfo">Accept</button><button class="btn btn-danger denyInfo">Deny</button></div></td>';
            echo "<td>".$row['artist']."</td>";
            echo "<td>".$row['trackname']."</td>";
            echo "<td><img src='".$imagePath.$row['info']."'></td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['submission_time']."</td>";
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
            $.post('SongInfo_controller.php', {'action':'adminSignIn', 'password':password}, function(data){
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