<?php
require_once '../songabout_lib/DB.php';
	
class SongAboutVerifiedArtist {
	public $verified_artist_id;	
	public $user_id;
	public $artist_id;
	public $create_date;
	public $status;
	public $who_verified;
	public $artist_name;
	public $profile_image_url;
	public $user_claiming_name;

	public function __construct($verified_artist_id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($verified_artist_id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (trim($verified_artist_id) == "") {
			$sql = "SELECT * FROM songabout_verified_artist WHERE verified_artist_id = ".$verified_artist_id;
		} else if (is_numeric($verified_artist_id)) {
			$user_id = (int)$user;
			$sql = "SELECT * FROM songabout_verified_artist WHERE verified_artist_id = ".$verified_artist_id;
		} 
		if (isset($sql)) {
			
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {
				$row = @$rs->fetch_assoc();
				$this->verified_artist_id = (int)$row['verified_artist_id'];
				$this->user_id = $row['user_id']; 
				$this->artist_id = $row['artist_id'];
				$this->create_date = $row['status'];	
				$this->status = $row['create_date'];		
				$this->who_verified = stripslashes($row['who_verified']);		
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
			}
		}
	}
	
	public function save() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if($this->verified_artist_id === NULL || $this->verified_artist_id === "") { 
			$sql = 'Insert into songabout_verified_artist (user_id,artist_id) values (' . $db->cleanFormat($this->user_id) . ', ' . $db->cleanFormat($this->artist_id) . ')';
			$rs = @$db->query($sql);

			return mysql_insert_id();
		} else {
			$sql = 'Update songabout_verified_artist SET ';
			$sql .= 'user_id=' . $db->cleanFormat($this->user_id) . ',';
			$sql .= 'artist_id=' . $db->cleanFormat($this->artist_id) . ',';
			$sql .= 'status="' . $db->cleanFormat($this->status) . '",';
			$sql .= 'who_verified=' . $db->cleanFormat($this->who_verified) . ' ';
			$sql .= 'WHERE verified_artist_id=' . $this->verified_artist_id;
			
			$rs = @$db->query($sql);

			return mysql_insert_id();
		}
	}	
	
	public function deleteFromDB() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");

		if(isset($this->verified_artist_id)) {
			$sql = 'Delete from songabout_verified_artist where verified_artist_id = ' . $this->verified_artist_id;
			$rs = @$db->query($sql);
		}
	}
	
	public function verifyArtistUser($artist_id, $user_id, $who_verified) {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		
		$sql = 'Update songabout_verified_artist SET ';
		$sql .= 'user_id=' . $db->cleanFormat($user_id) . ',';
		$sql .= 'artist_id=' . $db->cleanFormat($this->artist_id) . ',';
		$sql .= 'who_verified=' . $db->cleanFormat($who_verified) . ',';
		$sql .= 'WHERE artist_id=' . $artist_id . " and user_id=" . $user_id;
		
		$rs = @$db->query($sql);

		return mysql_insert_id();		
	}

	public function fetchAllVerfied ($page = 1, $howMany = 30, $filterSQL = '', $orderBySQL = "  artist_name DESC") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$entries = array();						 
		$startAt = ($page - 1) * $howMany;
		$endAt = $howMany;
		
		// This is updated to true once the database return information on if the artist information has been updated for the day. 
		$isCurrent = false;
		
		if($orderBySQL === NULL) {
			$orderBySQL =  " artist_name DESC"; 
		}
		
		if($userID === NULL || $userID == "") {
			$userID = 0; 
		}
		

		$sql = "SELECT svu.*, sa.artist_name, sa.profile_image_url, su.username FROM songabout_verified_artist svu left outer join songabout_artist sa ON sa.artist_id = svu.artist_id left outer join songabout_user su ON su.user_id = svu.user_id WHERE sa.artist_name <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		
		if (isset($sql)) {	
			$resultSet = @$db->query($sql);
			if ($resultSet->num_rows > 0) {
				while($row = $resultSet->fetch_assoc()){	
					$entry = new SongAboutVerifiedArtist();	

					$entry->verified_artist_id = (int)$row['verified_artist_id'];
					$entry->user_id = $row['user_id']; 
					$entry->artist_id = $row['artist_id'];
					$entry->create_date = $row['create_date'];		
					$entry->status = $row['status'];	
					$entry->who_verified = $row['who_verified'];	
					$entry->profile_image_url = $row['profile_image_url'];
					$entry->artist_name = $row['artist_name'];	
					$entry->user_claiming_name = $row['username'];	
														
					$entries[] = $entry;
				}	
			} 
		}	
		return $entries;    
	}	
	
}