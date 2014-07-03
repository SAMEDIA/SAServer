<?php
require_once '/home/songabou/songabout_lib/DB.php';
	
class SongAboutUser {
	public $user_id;
	public $username;
	public $display_name;
	public $profile_img_url;
	public $facebook_username;
	public $twitter_username;
	public $soundcloud_username;
		
	public function __construct($user = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($user) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (trim($user) == "") {
			$user_id = (int)$_SESSION['user_id'];
			$sql = "SELECT * FROM songabout_user WHERE user_id = ".$user_id;
		} else if (is_numeric($user)) {
			$user_id = (int)$user;
			$sql = "SELECT * FROM songabout_user WHERE user_id = ".$user_id;
		} else {
			$user = $db->real_escape_string(strtolower(trim($user)));
			$sql = "SELECT * FROM songabout_user WHERE LOWER(username) = '".$user."'";
		}
		if (isset($sql)) {
			
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {
				$row = @$rs->fetch_assoc();
				$this->user_id = (int)$row['user_id'];
				$this->display_name = $row['display_name'];
				$this->profile_img_url = $row['profile_img_url'];		
				$this->username = stripslashes($row['username']);
				$this->facebook_username = stripslashes($row['facebook_username']);
				$this->twitter_username = stripslashes($row['twitter_username']);
				$this->soundcloud_username = stripslashes($row['soundcloud_username']);
				$this->date_created = stripslashes($row['date_created']);			
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
			}
		}
	}
	
	public function getUserId() {
		return $this->user_id;

	}
	
	// Alias to get user ID
	public function getId() {
		return $this->getUserId();
	}
	
	// Get username
	public function getUsername() {
		return $this->username;
	}
	
	// Alias to get username
	public function getUser() {
		return $this->username;
	}
	
	public function save() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if($this->user_id === NULL || $this->user_id === "") { 
			$sql = 'Insert into songabout_user (username) values ("' . $db->cleanFormat($this->username) . '")';
			$rs = @$db->query($sql);
			return mysql_insert_id();
		} else {
			$sql = 'Update songabout_user SET ';
			$sql .= 'display_name="' . $db->cleanFormat($this->display_name) . '",';
			$sql .= 'profile_img_url="' . $db->cleanFormat($this->profile_img_url) . '",';
			$sql .= 'username="' . $db->cleanFormat($this->username) . '",';
			$sql .= 'facebook_username="' . $db->cleanFormat($this->facebook_username) . '",';
			$sql .= 'twitter_username="' . $db->cleanFormat($this->twitter_username) . '",';
			$sql .= 'soundcloud_username="' . $db->cleanFormat($this->soundcloud_username) . '"';
			$sql .= 'WHERE user_id=' . $this->user_id;
			
			$rs = @$db->query($sql);
			return mysql_insert_id();
		}
	}
	
	public function saveAll() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$sql = 'Insert into songabout_user (display_name, username, facebook_username, twitter_username, soundcloud_username) ';
		$sql .= 'values ("' . $db->cleanFormat($this->display_name) . '", "' . $db->cleanFormat($this->username) . '", "' . $db->cleanFormat($this->facebook_username) . '", "' . $db->cleanFormat($this->twitter_username) . '", "' . $db->cleanFormat($this->soundcloud_username) . '")"';
		$rs = @$db->query($sql);
		return mysql_insert_id();
	}	
}