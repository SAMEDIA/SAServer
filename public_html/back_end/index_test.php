<!DOCTYPE html>
<!--<?php session_start();?>-->
<html>
<head>
<title>Song Detail and User</title>
<meta charset="UTF-8">
<style type="text/css">
p.frame  {
	border-width:1px;
	border-style:solid;
	width:300px;
}
</style>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
		
<header>
	

	<?php 
	// load models
	require_once "User.php";
	require_once "SongInfo.php";
	?>
	<fieldset>
		<?php
		require_once "user_panel.php";
		?>
	</fieldset>
	<fieldset>
		
	<?php
		echo SongInfo::searchSong('helloweihan',10);
	?>
	</fieldset>

	<fieldset>
		<?php
		require_once "new_song.php";
		require_once "song_detail.php";
		?>
	</fieldset>
	
	
</header>
<section>
<!-- homepage main body -->
</section>

</body>
</html>