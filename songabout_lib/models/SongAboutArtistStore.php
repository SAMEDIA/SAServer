<?php
require_once '../songabout_lib/DB.php';

// Caches Data from echonest for the homepage of a site.  To cache only last a day and updates each day.
// Copyrighted 2012 By Aaron Ho (sosimpull@gmail.com) licensed for use on Songabout.

class SongAboutArtistStore {
	public $artist_store_id;	
	public $artist_name;
	public $artist_store_url;
	public $artist_id;
	public $create_date;

	public function __construct($id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (is_numeric($id)) {
			$artist_store_id = (int) $db->cleanFormat($id);
			$sql = "SELECT * FROM songabout_artist_store_links WHERE artist_store_id = " . $artist_store_id;
		} else {
			$artist_name = $db->cleanFormat($id);
			$sql = "SELECT * FROM songabout_artist_store_links WHERE artist_name = '" . $artist_name . "'";
		}

		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {				
				$row = @$rs->fetch_assoc();

				$this->artist_store_id = $db->cleanFormat($row['artist_store_id']);
				$this->artist_name = $db->cleanFormat($row['artist_name']);
				$this->artist_store_url = $db->cleanFormat($row['artist_store_url']);
				$this->artist_id = $db->cleanFormat($row['artist_id']);
				$this->create_date = $db->cleanFormat($row['create_date']);
				
			} else {
				return false;
			}
		}
	}
	
	public function fetchAllArtist($page = 1, $howMany = 30, $genre = 'All', $filterSQL = '', $userID = 0, $orderBySQL = "  artist_name DESC") {
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
		
		if($genre == 'All') {
			$sql = "SELECT ac.* FROM songabout_artist_store_links ac WHERE ac.artist_name <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		} else {
			$sql = "SELECT ac.* FROM songabout_artist_store_links ac WHERE ac.artist_name <> '' <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		}
				
		if (isset($sql)) {	
			$resultSet = @$db->query($sql);
			if ($resultSet->num_rows > 0) {
				while($row = $resultSet->fetch_assoc()){	
					$entry = new SongAboutArtistStore();	
					$entry->artist_store_id = $db->cleanFormat($row['artist_store_id']);
					$entry->artist_name = $db->cleanFormat($row['artist_name']);
					$entry->artist_store_url = $db->cleanFormat($row['artist_store_url']);
					$entry->artist_id = $db->cleanFormat($row['artist_id']);
					$entry->create_date = $db->cleanFormat($row['create_date']);
														
					$entries[] = $entry;
											
					// Add a check to date to make sure that the data is only one day old.  If it is older then run the updateDailyData function
					if(date('Ymd') == date('Ymd', strtotime($row['create_date']))) {
						//updateDailyData();
					}
				}	
			} 
		}	
		return $entries;    
	}		
	
	public function save() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$sql = "Insert into songabout_artist_store_links (artist_name, artist_store_url, artist_id) ";
		$sql .= "values ('" . $db->cleanFormat($this->artist_name) . "', '" . $db->cleanFormat($this->artist_store_url) . "', '" . $db->cleanFormat(artist_id) . "')";
		$rs = @$db->query($sql);
		return mysql_insert_id();	
	}
}
?>