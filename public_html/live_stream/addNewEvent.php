<?php
	session_start();
	include ('connect_database.php');
	$url="vieweventinfo.php";
	$errorurl="postneweventlink.php";
	
	$livestream_category=$_POST['event_type'];
	$livestream_name=$_POST['event_name'];
	$livestream_time=$_POST['start_time'];
	$livestream_artist_name=$_POST['artist'];
	$livestream_genre=$_POST['genre'];
	$livestream_link=$_POST['links'];
	$livestream_place=$_POST['place'];
	$livestream_time_zone=$_SESSION['time_zone'];
	$livestream_source_name=$_POST['source_name'];
	$checksql = "SELECT * FROM songabout_live_stream WHERE livestream_link='".$livestream_link."'";
	$checkres = mysqli_query($connection,$checksql);
	if(!isset($checkres)){
		$sql = "INSERT INTO songabout_live_stream (livestream_time_zone,livestream_place,livestream_source_name,livestream_name,livestream_genre,livestream_artist_name,livestream_link,livestream_category,livestream_time) VALUES ('".$livestream_time_zone."','".$livestream_place."','".$livestream_source_name."','".$livestream_name."','".$livestream_genre."','".$livestream_artist_name."','".$livestream_link."','".$livestream_category."','".$livestream_time."')";
		$res = mysqli_query($connection,$sql);
		if($res==TRUE){
			$sql="SELECT * FROM songabout_live_stream WHERE livestream_link='".$livestream_link."'";
			$res = mysqli_query($connection,$sql);
			$row = mysqli_fetch_array($res);
			$_SESSION['livestream_id']=$row['livestream_id'];
			$_SESSION['livestream_category']=$row['livestream_category'];
			$_SESSION['livestream_name']=$row['livestream_name'];
			$_SESSION['livestream_time']=$row['livestream_time'];
			$_SESSION['livestream_artist_name']=$row['livestream_artist_name'];
			$_SESSION['livestream_genre']=$row['livestream_genre'];
			$_SESSION['livestream_link']=$row['livestream_link'];
			$_SESSION['livestream_place']=$row['livestream_place'];
			$_SESSION['livestream_time_zone']=$row['livestream_time_zone'];
			$_SESSION['livestream_source_name']=$row['livestream_source_name'];
			Header("Location: $url");
		}
		else{
			$_SESSION['errmsg'] = "Database Error, please upload again!";
			Header("Location: $errorurl");
		}
	}
	else{
		$_SESSION['errmsg'] = "Concert Already Exists!";
		Header("Location: $errorurl");
	}
?>