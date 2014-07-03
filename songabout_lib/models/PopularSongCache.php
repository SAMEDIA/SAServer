<?php
require_once '/home/songabou/songabout_lib/DB.php';

// Caches Data from echonest for the homepage of a site.  To cache only last a day and updates each day.
// Copyrighted 2012 By Aaron Ho (sosimpull@gmail.com) licensed for use on Songabout.

class PopularSongCache {
	public $song_id;	
	public $echonest_song_id;
	public $song_title;
	public $artist_name;
	public $cover_image_url;
	public $day_rating;
	public $create_date;

	public function __construct($id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (is_numeric($id)) {
			$songId = (int) $db->cleanFormat($id);
			$sql = "SELECT * FROM simp_song_cache WHERE song_id = " . $songId;
		} else {
			$echonestSongId = $db->cleanFormat($id);
			$sql = "SELECT * FROM simp_song_cache WHERE echonest_song_id = '" . $echonestSongId . "'";
		}
		
		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {				
				$row = @$rs->fetch_assoc();
				$this->echonest_song_id = $row['echonest_song_id'];
				$this->song_title = $db->cleanFormat($row['song_title']);
				$this->artist_name = $db->cleanFormat($row['artist_name']);				
				$this->cover_image_url = $db->cleanFormat($row['cover_image_url']);
				$this->day_rating = $db->cleanFormat($row['day_rating']);
				$this->create_date = $db->cleanFormat($row['create_date']);
				
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
			}
		}
	}
	
	public function fetchAllSongs($page = 1, $howMany = 30, $genre = 'All', $filterSQL = '', $userID = 0, $orderBySQL = "  artist_name DESC") {
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
			$sql = "SELECT DISTINCT ac.song_id, ac.echonest_song_id, ac.song_title, ac.artist_name, ac.cover_image_url FROM simp_song_cache ac WHERE ac.artist_name <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		} else {
			$sql = "SELECT DISTINCT ac.song_id, ac.echonest_song_id, ac.song_title, ac.artist_name, ac.cover_image_url FROM simp_song_cache ac WHERE ac.artist_name <> '' " . $filterSQL . " order by " . $orderBySQL . " LIMIT " . $startAt . ", " . $endAt . " ";
		}
				
		
		if (isset($sql)) {	
			$resultSet = @$db->query($sql);
			if ($resultSet->num_rows > 0) {
				while($row = $resultSet->fetch_assoc()){	
					$entry = new PopularSongCache();	
					$entry->echonest_song_id = $row['echonest_song_id'];
					$entry->song_title = $db->cleanFormat($row['song_title']);
					$entry->artist_name = $db->cleanFormat($row['artist_name']);				
					$entry->cover_image_url = $db->cleanFormat($row['cover_image_url']);
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
		$sql = "Insert into simp_song_cache (song_title, artist_name, echonest_song_id, cover_image_url, day_rating) ";
		$sql .= "values ('" . $db->cleanFormat($this->song_title) . "', '" . $db->cleanFormat($this->artist_name) . "', '" . $db->cleanFormat($this->echonest_song_id) . "', '" . $db->cleanFormat($this->cover_image_url) . "', '" . $db->cleanFormat($this->day_rating) . "')";
		$rs = @$db->query($sql);
		return mysql_insert_id();	
	}
	
	public function updateDailyData() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$echoNestAPIKey = 'YTEIFSAM5TAJZ4JBR';
		require_once '/home/songabou/lib/EchoNest/Autoloader.php';
		EchoNest_Autoloader::register();
		$songAboutEchonest = new EchoNest_Client();
		$songAboutEchonest->authenticate($echoNestAPIKey);		
		
		$topSongs = $songAboutEchonest->getSongApi()->search(array('results' => '100', 'sort' => 'song_hotttnesss-desc', 'bucket' => array("id:7digital-US", "tracks", "song_hotttnesss")));
		$sqlDelete .= "Delete from simp_song_cache";
		$rsDelete = @$db->query($sqlDelete);
		$songCount = 0;
		foreach ($topSongs as &$song) {				
			if(isset($song["id"]) && $song["id"] != "" && isset($song["tracks"][0]["release_image"]) && $song["tracks"][0]["release_image"] != "") {
					$songCount++;
					$tempSong = new PopularSongCache();
					$tempSongCheck = new PopularSongCache($song["id"]);

					//if($tempSongCheck->song_title == "") {
						$tempSong->song_title = $song["title"];
						$tempSong->artist_name = $song["artist_name"];
						$tempSong->echonest_song_id = $song["id"];
						$tempSong->cover_image_url = $song["tracks"][0]["release_image"];
						$tempSong->day_rating = $song["song_hotttnesss"];
	
						$tempSong->save();
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