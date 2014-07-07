<?php
require_once '../songabout_lib/DB.php';
	
class UserFacebook {
	public $user_facebook_id;	
	public $user_id;
	public $facebook_user_id;
	public $oauth_uid;
	public $facebook_email;

	public function __construct($id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (is_numeric($id)) {
			$user_id = (int) $id;
			$sql = "SELECT * FROM sa_user_facebook WHERE facebook_user_id = " . $user_id;
		} 
		
		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {
				$row = @$rs->fetch_assoc();
				$this->user_facebook_id = (int)$row['user_facebook_id'];
				$this->user_id = stripslashes($row['user_id']);
				$this->facebook_user_id = stripslashes($row['facebook_user_id']);
				$this->oauth_uid = stripslashes($row['oauth_uid']);
				$this->facebook_email = stripslashes($row['facebook_email']);
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
			}
		}
	}
	
	public function save() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$sql = 'Insert into sa_user_facebook (user_id, facebook_user_id, oauth_uid) ';
		$sql .= 'values (' . $this->user_id . ', ' . $this->facebook_user_id . ', ' . $this->oauth_uid . ')';
		$rs = @$db->query($sql);
		return mysql_insert_id();	
	}
}

?>