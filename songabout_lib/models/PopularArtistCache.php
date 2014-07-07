<?php
require_once '../songabout_lib/DB.php';

// Caches Data from echonest for the homepage of a site.  To cache only last a day and updates each day.
// Copyrighted 2012 By Aaron Ho (sosimpull@gmail.com) licensed for use on Songabout.

class PopularArtistCache {
	public $artist_id;	
	public $echonest_id;
	public $artist_name;
	public $profile_image_url;
	public $day_rating;
	public $create_date;

	public function __construct($id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (is_numeric($id)) {
			$artist_id = (int) $db->cleanFormat($id);
			$sql = "SELECT * FROM simp_artist_cache WHERE artist_id = " . $artist_id;
		} else {
			$artist_name = $db->cleanFormat($id);
			$sql = "SELECT * FROM simp_artist_cache WHERE artist_name = '" . $artist_name . "'";
		}
		
		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {				
				$row = @$rs->fetch_assoc();
				$this->echonest_id = $row['echonest_id'];
				$this->artist_id = $db->cleanFormat($row['artist_id']);
				$this->artist_name = $db->cleanFormat($row['artist_name']);
				$this->profile_image_url = $db->cleanFormat($row['profile_image_url']);
				$this->day_rating = $db->cleanFormat($row['day_rating']);
				$this->create_date = $db->cleanFormat($row['create_date']);
				
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
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
			$sql = "SELECT ac.* FROM simp_artist_cache ac WHERE ac.artist_name <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		} else {
			$sql = "SELECT ac.* FROM simp_artist_cache ac WHERE ac.artist_name <> '' <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		}
				
		if (isset($sql)) {	
			$resultSet = @$db->query($sql);
			if ($resultSet->num_rows > 0) {
				while($row = $resultSet->fetch_assoc()){	
					$entry = new PopularArtistCache();	
					$entry->echonest_id = $row['echonest_id'];
					$entry->artist_id = $db->cleanFormat($row['artist_id']);
					$entry->artist_name = $db->cleanFormat($row['artist_name']);
					$entry->profile_image_url = $db->cleanFormat($row['profile_image_url']);
					$entry->day_rating = $db->cleanFormat($row['day_rating']);
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
		$sql = "Insert into simp_artist_cache (artist_name, echonest_id, profile_image_url, day_rating) ";
		$sql .= "values ('" . $db->cleanFormat($this->artist_name) . "', '" . $db->cleanFormat($this->echonest_id) . "', '" . $db->cleanFormat($this->profile_image_url) . "', '" . $db->cleanFormat($this->day_rating) . "')";
		$rs = @$db->query($sql);
		return mysql_insert_id();	
	}
	
	public function updateDailyData() {
		// This function is called daily whenever an instance of this class is created for the first time each day.
		
		// Songabout Addon During the udpate of the cache artist should be check to make sure they are not in the main system
		
		// This is the main infromation API
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$echoNestAPIKey = 'YTEIFSAM5TAJZ4JBR';
		require_once '../lib/EchoNest/Autoloader.php';
		EchoNest_Autoloader::register();
		$songAboutEchonest = new EchoNest_Client();
		$songAboutEchonest->authenticate($echoNestAPIKey);		
		
		$topArtists = $songAboutEchonest->getArtistApi()->search(array('results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));
		
		$sqlDelete .= "Delete from simp_artist_cache";
		$rsDelete = @$db->query($sqlDelete);
		
		
		foreach ($topArtists as &$artist) {				
			if(isset($artist["id"]) && $artist["id"] != "" && isset($artist["images"][0]["url"]) && $artist["images"][0]["url"] != "") {
					$tempArtistCache= new PopularArtistCache();	
					//$tempArtistCheck = new PopularArtistCache($artist["name"]);
				
					//if($tempArtistCheck->artist_name == ""){
						$tempArtistCache->artist_name = $artist["name"];
						$tempArtistCache->echonest_id = $artist["id"];
						$tempArtistCache->profile_image_url = $artist["images"][0]["url"];
						$tempArtistCache->day_rating = $artist["hotttnesss"];
						
						$tempArtistCache->save();
					//}
			}
		}
		
		// delete all of yesterday's data
		
		// SongAbout Addon
			// Add code to check if the artist is already in songabout db if not then insert it
		// End Song Addon
	}
}
?>