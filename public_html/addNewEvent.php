<?php

	session_start();

	require_once '../songabout_lib/DB.php';

	require_once '../lib/LastFM/lastfm.api.php';

	//get picture of the artist

	$LAST_FM_API_KEY='2b79d5275013b55624522f2e3278c4e9';

	CallerFactory::getDefaultCaller()->setApiKey($LAST_FM_API_KEY);

	$db = SongAboutDB::getInstance("songabou_sa_production_db");

	$url="vieweventinfo.php";

	$errorurl="postneweventlink.php";

	//$thsss = json_encode($_POST['links']);

	//echo $thsss;

	//var_dump($_POST['links']);

	//echo "<iframe width='100%' height='100%' src='http://www.ustream.tv/embed/4917009?autoplay=true?ub=ff3d23&lc=ff3d23&oc=ffffff&uc=ffffff&v=3&wmode=direct' scrolling='no' frameborder='0' style='border: 0px none transparent;'> </iframe>";

	if(isset($_POST['links']) && isset($_POST['event_name']) && isset($_POST['artist'])){

		$livestream_category=$_POST['event_type'];

		$livestream_name=$_POST['event_name'];

		$livestream_time=date("Y-m-d H:i:s",strtotime((string)$_POST['start_time']));

		$livestream_artist_name=$_POST['artist'];

		$livestream_genre=$_POST['genre'];

		if(strpos($_POST['links'], 'iframe')){

			$livestream_link = 'thisiframe'.substr($_POST['links'],40,-81);

		}

		else{

			$livestream_link = $_POST['links'];

		}

		//$livestream_link=json_encode($_POST['links']);

		//$livestream_link = (string)$_POST['links'][1:-10];

		$livestream_place=$_POST['place'];

		$livestream_time_zone=$_SESSION['time_zone'];

		$livestream_source_name=$_POST['source_name'];

		//check all parameters

		$checksql = "SELECT * FROM songabout_live_stream WHERE livestream_name='".$livestream_name."' AND livestream_link ='".$livestream_link."'";

		$checkres = @$db->query($checksql);

		$checkres = $checkres->num_rows;

		if($checkres==0){

			$limit = 1;

			$lastfmres = Artist::search($livestream_artist_name, $limit);

			if(isset($lastfmres)){

				$artist = $lastfmres->current();

				$livestream_img = $artist->getImage(4);

			}

			else{

				$livestream_img = "none";

			}

			$livestream_lon="none";

			$livestream_lag="none";

			$sql = "INSERT INTO songabout_live_stream (livestream_time_zone,livestream_place,livestream_source_name,livestream_name,livestream_genre,livestream_artist_name,livestream_link,livestream_category,livestream_time,livestream_lon,livestream_lat,livestream_img) VALUES ('".$livestream_time_zone."','".$livestream_place."','".$livestream_source_name."','".$livestream_name."','".$livestream_genre."','".$livestream_artist_name."','".$livestream_link."','".$livestream_category."','".$livestream_time."','".$livestream_lon."','".$livestream_lag."','".$livestream_img."')";

			$res = @$db->query($sql);

			$sql="SELECT * FROM songabout_live_stream WHERE livestream_link='".$livestream_link."'";

			$res = @$db->query($sql);

			$row = @$res->fetch_assoc();

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

			$_SESSION['errmsg'] = "Concert Already Exists!";

			Header("Location: $errorurl");

		}

	}

	else{

		$_SESSION['errmsg'] = "Please fill the required fields!";

		Header("Location: $errorurl");

	}



	if(isset($_GET['event_id'])){

		$event_id = $_GET['event_id'];

		$sql="SELECT * FROM songabout_live_stream WHERE livestream_id='".$event_id."'";

		$res = @$db->query($sql);

		$row = @$res->fetch_assoc();

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



		$limit = 1;

		$lastfmres = Artist::search($row['livestream_artist_name'], $limit);

		if(isset($lastfmres)){

			$artist = $lastfmres->current();

			$livestream_img = $artist->getImage(4);

		}

		else{

			$livestream_img = "none";

		}

		$_SESSION['livestream_img'] = $livestream_img;



		Header("Location: $url");

	}

?>