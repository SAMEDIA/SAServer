<?php
	//test values
	var_dump($result);
	$event_name="event_nameVALUE";
	$event_category="event_categoryVALUE";
	$start_time="start_timeVALUE";
	$count_down="count_downVALUE";
	$artist_name="artist_nameVALUE";
	$event_genre="event_genreVALUE";
	$link="linkVALUE";
	$place="placeVALUE";
	$source_name="source_nameVALUE";
	//
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
