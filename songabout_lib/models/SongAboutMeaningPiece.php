<?php
require_once '../songabout_lib/DB.php';
session_start();
	
class SongAboutMeaningPiece {
	public $song_piece_id;	
	public $song_id;
	public $piece_number;
	public $meanting_text;
	public $user_who_entered;	
	public $create_date;

	public function __construct($id = "") {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		if (trim($id) == "") {
			//$this->logged = $this->exists = false;
			//$this->_userIsNew = true;
		} else if (is_numeric($song_id)) {
			$artist_id = (int) $db->cleanFormat($song_id);
			$sql = "SELECT * FROM songabout_song_meaning_piece WHERE song_id = " . $song_id;
		} 
		
		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {
				$row = @$rs->fetch_assoc();
				$this->song_piece_id = (int)$row['song_piece_id'];
				$this->song_id = $db->cleanFormat($row['song_id']);
				$this->piece_number = $db->cleanFormat($row['piece_number']);
				$this->meanting_text = $row['meanting_text'];
				$this->user_who_entered = $db->cleanFormat($row['user_who_entered']);
			} else {
				//$this->logged = $this->exists = false;
				//$this->_userIsNew = true;
			}
		}
	}
	
	public function save() {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		
		if(isset($this->song_id) and isset($this->piece_number)){
			$sqlDelete = 'Delete from songabout_song_meaning_piece where song_id = ' . $db->cleanFormat($this->song_id) . ' and piece_number = ' . $db->cleanFormat($this->piece_number);
			$rs = @$db->query($sqlDelete);
		}
		
		$sql = 'Insert into songabout_song_meaning_piece (song_id, meanting_text,piece_number,user_who_entered) ';
		$sql .= 'values (' . $db->cleanFormat($this->song_id) . ', "' . $db->cleanFormat($this->meanting_text) . '",' . $db->cleanFormat($this->piece_number) . ',' . $_SESSION['activeUser']->user_id . ')';
		$rs = @$db->query($sql);
		return mysql_insert_id();	
	}
	
	public function update() {
		
	}
	
	public function fetchAllBySongPiece($songId, $pieceNumber) {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		
		$sql = "SELECT * FROM songabout_song_meaning_piece WHERE song_id = " . $song_id . " and piece_number = " . $pieceNumber;
		
		if (isset($sql)) {
			$rs = @$db->query($sql);
			if ($rs->num_rows > 0) {
				$entry = new SongAboutMeaningPiece();
				
				$row = @$rs->fetch_assoc();
				$entry->song_piece_id = (int)$row['song_piece_id'];
				$entry->song_id = $db->cleanFormat($row['song_id']);
				$entry->piece_number = $db->cleanFormat($row['piece_number']);
				$entry->meanting_text = $row['meanting_text'];
				$entry->user_who_entered = $db->cleanFormat($row['user_who_entered']);
				
				return $entry;
			} 
			return false;
		}		
	}

	public function fetchAllBySong($songId) {
		$db = SongAboutDB::getInstance("songabou_sa_production_db");
		$entries = array();						 ;
		
		// This is updated to true once the database return information on if the artist information has been updated for the day. 
		$isCurrent = false;
		
		if($orderBySQL === NULL) {
			$orderBySQL =  " piece_number DESC"; 
		}
		
		$sql = "SELECT smc.* FROM songabout_song_meaning_piece smc WHERE song_id = " . $songId . " order by " . $orderBySQL;
					
		if (isset($sql)) {	
			$resultSet = @$db->query($sql);
			if ($resultSet->num_rows > 0) {
				while($row = $resultSet->fetch_assoc()){	
					$entry = new SongAboutMeaningPiece();	
					
					$entry->song_piece_id = $row['song_piece_id'];
					$entry->song_id = $db->cleanFormat($row['song_id']);
					$entry->piece_number = $db->cleanFormat($row['piece_number']);				
					$entry->meanting_text = $row['meanting_text'];
					$entry->user_who_entered = $db->cleanFormat($row['user_who_entered']);
					$entry->create_date = $db->cleanFormat($row['create_date']);
					 
					if($entries[$entry->piece_number] == "") {							
						$entries[$entry->piece_number] = $entry;
					}
				}	
			} 
		}	
		return $entries;    
	}	
}
?>