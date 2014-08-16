<?php
	session_start();
	public $url="vieweventinfo.php"
	require_once 'SongAboutLiveStream.php';	
		//initialize parameters
		public $event_type;
		public $event_name;
		public $start_time;
		public $artist;
		public $genre;
		public $links;
		public $place;
		public $time_zone;
		public $source_name;
		if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['links'])){
			$event_type=$_POST['event_type'];
			$event_name=$_POST['event_name'];
			$start_time=$_POST['start_time'];
			$artist=$_POST['artist'];
			$genre=$_POST['genre'];
			$links=$_POST['links'];
			$place=$_POST['place'];
			//$time_zone=$_POST['time_zone'];
			$source_name=$_POST['source_name'];
			$rs = insertstreaminfo($start_time,$time_zone,$place,$source_name,$event_name,$genre,$artist,$links,$event_type);
			if($rs == 0){
				echo "SUCCESS!"
				// $errmsg =1;
				// $result=getstreaminfobyid($livestream_id)；

				// $this->render('vieweventinfo', array('$result'=>$result));
				// Header("Location: $url");

			}
			elseif($rs == 1){
				$errmsg = "Cannot insert data, please contact website administrator.";
			}
			else{
				$errmsg = "Unkown Error, please contact website administrator.";
			}
		}
		elseif(!isset($_POST['links'])){
			$errmsg=0;
			$header("vieweventinfo.php");
		}
		elseif ($_SERVER["REQUEST_METHOD"]=="GET" && isset($_POST['event_id'])) {
			
		}



	
?>