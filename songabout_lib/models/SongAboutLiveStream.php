<?php
require_once '../songabout_lib/DB.php';

$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "songabou_sa_production_db"; // the name of the database that you are going to use for this project
$dbuser = "schoolin_devuser"; // the username that you created, or were given, to access your database
$dbpass = "Lz7+i=TMFfWh"; // the password that you created, or were given, to access your database
 
mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());
	class SongAboutLiveStream {

	public $livestream_id;
	public $livestream_time;
	public $livestream_time_zone;
	public $livestream_place;
	public $livestream_source_name;
	public $livestream_name;
	public $livestream_genre;
	public $livestream_artist_name;
	public $livestream_link;
	public $livestream_type;
	public $errormsg;
	public $livestream_id_list=array();
	public $db = SongAboutDB::getInstance("songabou_sa_production_db");

	public function __construct($livestream_id=""){
		$livestream_id=$_POST['livestream_id'];
		$sql = "SELECT * FROM songabout_live_stream WHERE livestream_id ='".$livestream_id"'";
		$rs = @$db->query($sql);
		if ($rs->num_rows > 0) {
				$row = @$rs->fetch_assoc();
				$this->livestream_id = (int)$row['livestream_id'];
				$this->livestream_time = $row['livestream_time'];
				$this->livestream_time_zone = $row['livestream_time_zone'];
				$this->livestream_place = $row['livestream_place'];		
				$this->livestream_source_name = $row['livestream_source_name'];
				$this->livestream_name = $row['livestream_name'];
				$this->livestream_genre = $row['livestream_genre'];
				$this->livestream_artist_name = $row['livestream_artist_name'];
				$this->livestream_link = $row['livestream_link'];			
				$this->livestream_type = $row['livestream_type'];
			}
		else{
				$errormsg = "Cannot find livestream";
		}
		$sql = "SELECT livestream_id FROM songabout_live_stream;";
		$listrs = @$db->query($sql);
		if($listrs->num_rows > 0){
			foreach($listrs as $a){
				array_push($livestream_id_list, $a);
			}
		}
	}

	public function insertstreaminfo($livestream_time,$livestream_time_zone,$livestream_place,$livestream_source_name,
									$livestream_name,$livestream_genre,$livestream_artist_name,$livestream_link,$livestream_type){
		$sql = "INSERT INTO songabout_live_stream "
			."(livestream_time，livestream_time_zone,livestream_place,livestream_source_name,livestream_name,livestream_genre,"
			."livestream_artist_name,livestream_link,livestream_type)VALUES(".$livestream_time.",'".$livestream_time_zone."','".$livestream_place."','"
			.$livestream_source_name."','".$livestream_name."','".$livestream_genre."','".$livestream_artist_name."','".$livestream_link."','".$livestream_type."')";
		$rs = @$db->query($sql);
		if($rs>0){
			return 0;
		}
		else{
			return 1;
		}
		
	}

	public function updatestreaminfo($livestream_time,$livestream_time,$livestream_time_zone,$livestream_place,$livestream_source_name,
									$livestream_name,$livestream_genre,$livestream_artist_name,$livestream_link,$livestream_type){
		$sql = "UPDATE songabout_live_stream SET livestream_time = '".$livestream_time."', livestream_time_zone ='".$livestream_time_zone
				."',livestream_place='".$livestream_place."',livestream_source_name='".$livestream_source_name."',livestream_name='".$livestream_name
				."',livestream_genre='".$livestream_genre."',livestream_artist_name='".$livestream_artist_name."',livestream_link='".$livestream_link
				."',livestream_type='".$livestream_type."' WHERE  livestream_id = ".$livestream_id;
		$rs = @$db->query($sql);
		if($rs>0){
			return $errormsg=1;
		}
		else{
			return $errormsg=0;
		}
	}

	public function getstreaminfobyid($livestream_id){
		$sql = "SELECT * FROM songabout_live_stream WHERE livestream_id =".$livestream_id;
		$rs = @$db->query($sql);
		if($rs>0){
			$row = @$rs->fetch_assoc();
			$this->livestream_id = $row['livestream_id'];
		}
		else{
			return $errormsg=0;
		}
	}
//getters
	public function getlivestream_id(){
		return $this->livestream_id;
	}
	public function getlivestream_time(){
		return $this->livestream_time;
	}
	public function getlivestream_time_zone(){
		return $this->livestream_time_zone;
	}
	public function getlivestream_place(){
		return $this->livestream_place;
	}
	public function getlivestream_source_name(){
		return $this->livestream_source_name;
	}
	public function getlivestream_name(){
		return $this->livestream_name;
	}
	public function getlivestream_genre(){
		return $this->livestream_genre;
	}
	public function getlivestream_artist_name(){
		return $this->livestream_artist_name;
	}
	public function getlivestream_link(){
		return $this->livestream_link;
	}
	public function getlivestream_type(){
		return $this->livestream_type;
	}
	public function geterrormsg(){
		return $this->errormsg;
	}

	public function getlivestream_id_list(){
		return $this->livestream_id_list;
	}

// setters
	public function setlivestream_id($data){
		$data = $this->livestream_id;
	}
	public function setlivestream_time($data){
		$data = $this->livestream_time;
	}
	public function setlivestream_time_zone($data){
		$data = $this->livestream_time_zone;
	}
	public function setlivestream_place($data){
		$data = $this->livestream_place;
	}
	public function setlivestream_source_name($data){
		$data = $this->livestream_source_name;
	}
	public function setlivestream_name($data){
		$data = $this->livestream_name;
	}
	public function setlivestream_genre($data){
		$data = $this->livestream_genre;
	}
	public function setlivestream_artist_name($data){
		$data = $this->livestream_artist_name;
	}
	public function setlivestream_link($data){
		$data = $this->livestream_link;
	}
	public function setlivestream_type($data){
		$data = $this->livestream_type;
	}
	public function setlivestream_id_list($data){
		$data = $this->livestream_id_list;
	}
}
?>