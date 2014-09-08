<?php

	session_start();

	require_once '../songabout_lib/DB.php';

	//require_once '../lib/LastFM/lastfm.api.php';

	//$LAST_FM_API_KEY='2b79d5275013b55624522f2e3278c4e9';

	//CallerFactory::getDefaultCaller()->setApiKey($LAST_FM_API_KEY);

	$url="event.php";

	$errorurl="index.php";

	

	$db = SongAboutDB::getInstance("songabou_sa_production_db");

	$sql = "DELETE FROM songabout_live_stream WHERE datediff(livestream_time,CURDATE())<'-3'";

	$res = @$db->query($sql);

	$sql = "SELECT * FROM songabout_live_stream WHERE datediff(livestream_time,CURDATE())>'-3' ORDER BY livestream_time LIMIT 50";

	$res = @$db->query($sql);

	$result=array();

	$i=0;

	while ($row =  @$res->fetch_assoc()) {

		$row['livestream_time'] = date("Y-m-d H:i:s",strtotime((string)$row['livestream_time']));

			$result[$i]= $row;

			$i++;

    }

    $_SESSION["eventlist"]=$result;

?>