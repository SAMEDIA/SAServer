<?php
	session_start();
	$event_id=$_SESSION['livestream_id'];
	$event_category;$_SESSION['livestream_category'];
	$event_name=$_SESSION['livestream_name'];
	$event_time=$_SESSION['livestream_time'];
	$event_artist=$_SESSION['livestream_artist_name'];
	$event_genre=$_SESSION['livestream_genre'];
	$event_link=$_SESSION['livestream_link'];
	$event_place=$_SESSION['livestream_place'];
	$event_time_zone=$_SESSION['livestream_time_zone'];
	$event_source_name=$_SESSION['livestream_source_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Event Info</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>

<body>
<div>
<?php echo $event_name; ?><?php echo $event_category;?>
</div>
<div>
<?php echo $start_time; ?>
</div>
<div><?php echo $count_down;?></div>
<div><?php echo $artist_name;?></div>
<div><?php echo $event_genre;?></div>
<div><?php echo $link;?></div>
<div><?php echo $place;?></div>
<div><?php echo $source_name;?></div>
<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>


</body>
</html>
