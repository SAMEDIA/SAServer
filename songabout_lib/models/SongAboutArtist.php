<?php
require_once '/home/songabou/songabout_lib/DB.php';
	
class SongAboutArtist {
	public $artist_id;	
	public $echonest_id;
	public $artist_slug;
	public $artist_name;
	public $profile_image_url;
	public $youtube_video_emb;
	public $create_date;

	public function __construct($id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (is_numeric($id)) {
			$artist_id = (int) $db->cleanFormat($id);
			$sql = "SELECT * FROM songabout_artist WHERE artist_id = " . $artist_id;
		} else {
			$artist_name =  $db->cleanFormat($id);
			$sql = "SELECT * FROM songabout_artist WHERE artist_name = '" . $artist_name . "'";
		}
		
		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {
				$row = @$rs->fetch_assoc();
				$this->echonest_id = (int)$row['echonest_id'];
				$this->artist_id = $db->cleanFormat($row['artist_id']);
				$this->artist_name = $db->cleanFormat($row['artist_name']);
				$this->profile_image_url = $db->cleanFormat($row['profile_image_url']);
				$this->youtube_video_emb = $row['youtube_video_emb'];
				$this->create_date = $db->cleanFormat($row['profile_image_url']);
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
				return false;
			}
		}
	}
	
	public function fetchAllArtist($page = 1, $howMany = 30, $genre = 'All', $filterSQL = '', $userID = 0, $orderBySQL = "  artist_name DESC") {
		$db = FratDB::getInstance("fratmusi_db");
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
		
		if($genre == 'All') {
			$sql = "SELECT fp.* FROM songabout_artist WHERE artist_name <> '' and artist_slug <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		} else {
			//$theGenre = new SongAboutGenre();
			//$theGenreID = $theGenre->getGenre($genre);
			
			$sql = "SELECT fp.* FROM songabout_artist WHERE artist_name <> '' and artist_slug <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		}
				
		
		if (isset($sql)) {	
			$resultSet = @$db->query($sql);
			if ($resultSet->num_rows > 0) {
				while($row = $resultSet->fetch_assoc()){	
					$entry = new SongAboutArtist();	
					$this->echonest_id = (int)$row['echonest_id'];
					$this->artist_id = $db->cleanFormat($row['artist_id']);
					$this->artist_name = $db->cleanFormat($row['artist_name']);
					$this->profile_image_url = $db->cleanFormat($row['profile_image_url']);
					$this->youtube_video_emb =$row['youtube_video_emb'];
					$this->create_date = $db->cleanFormat($row['profile_image_url']);
														
					$entries[] = $entry;
				}	
			} 
		}	
		return $entries;    
	}		
	
	public function save() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$sql = 'Insert into songabout_artist (artist_name, echonest_id, profile_image_url, youtube_video_emb) ';
		$sql .= 'values (\'' . $db->cleanFormat($this->artist_name) . '\', \'' . $db->cleanFormat($this->echonest_id) . '\', \'' . $db->cleanFormat($this->profile_image_url) . '\', \'' . $db->cleanFormat($this->youtube_video_emb) . '\')';
		$rs = @$db->query($sql);
		return mysql_insert_id();	
	}
}
?>