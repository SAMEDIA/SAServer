<?php

require_once "SADatabase.php";

class SongInfo {
	// get meaning from SongAbout.fm database
	public static function getMeaning($artist, $trackname) {
		$artist = SongInfo::normalize($artist);
		$trackname = SongInfo::normalize($trackname);
		$conn = SADatabase::getConnection();

		$meaning = NULL;

		if (!empty($artist) && !empty($trackname)) {
	    
			$stmt = $conn->prepare('SELECT * FROM song_meaning WHERE Artist = ? AND Trackname = ?');
			$stmt->bind_param('ss', $artist, $trackname);
			 
			// Execute statement
			$stmt->execute();

			// Get result
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {
				$row = $result->fetch_array();
				$meaning = $row['Meaning'];
			}
			
		}
		$stmt->close();
		return $meaning;
	}

	public static function submitMeaning($artist, $trackname, $meaning, $userID) {
		$artist = SongInfo::normalize($artist);
		$trackname = SongInfo::normalize($trackname);
		$conn = SADatabase::getConnection();

		$result = 'fail';

		if (!empty($artist) && !empty($trackname) && !empty($meaning) && !empty($userID)) {
			
			$stmt = $conn->prepare('INSERT INTO song_meaning_queue (Artist, Trackname, Meaning, UserID) VALUES(?, ?, ?, ?)');
			$stmt->bind_param('sssi', $artist, $trackname, $meaning, $userID);
			$stmt->execute();
			
			if($stmt->affected_rows == 1)
		    {
		        $result = 'success';
		    }
		    
		}

		$stmt->close();
		return $result;
	}

	public static function verifyMeaning($accept, $submissionID) {
		$conn = SADatabase::getConnection();

		// deny
	    if ($accept == 'false') {
	        // dequeue
			$stmt = $conn->prepare('UPDATE song_meaning_queue SET Processed = TRUE WHERE SubmissionID = ?');
			$stmt->bind_param('i', $submissionID);
			$stmt->execute();

	        // succesfully denied
	        if($stmt->affected_rows == 1)
		    {
		        echo 'success';
		    }
		    else echo 'fail';
	    } 
	    // accept
	    else if ($accept == 'true') {
	        // get meaning infomation
			$stmt = $conn->prepare('SELECT * FROM song_meaning_queue WHERE SubmissionID = ?');
			$stmt->bind_param('i', $submissionID);
			$stmt->execute();	        
			$queryResult = $stmt->get_result();
	        $row = $queryResult->fetch_array();
	        $artist = $row['Artist'];
	        $trackname = $row['Trackname'];
	        $meaning = $row['Meaning'];
	        $userID = $row['UserID'];
	        $stmt->close();

	        // dequeue
			$stmt = $conn->prepare('UPDATE song_meaning_queue SET Processed = TRUE WHERE SubmissionID = ?');
			$stmt->bind_param('i', $submissionID);
			$stmt->execute();
	        // succesfully dequeued
	        if($stmt->affected_rows != 1)
		    {
		        echo 'fail';
		    }

		    // check if meaning already exists
			$stmt = $conn->prepare('SELECT * FROM song_meaning WHERE Artist = ? AND Trackname = ?');
			$stmt->bind_param('ss', $artist, $trackname);
			$stmt->execute();	        
			$queryResult = $stmt->get_result();


	        // if meaning already in database, replace it
	        if ($queryResult->num_rows == 1) {
				$stmt = $conn->prepare('UPDATE song_meaning SET Meaning = ?, UserID = ? WHERE Artist = ? AND Trackname = ?');
	            $stmt->bind_param('siss', $meaning, $userID, $artist, $trackname);
	            $stmt->execute();
	            if ($stmt->affected_rows == 1) {
	                echo "success";
	            }
	            else echo "failed";
	        }
	        // if not, add it
	        else {
	            $stmt = $conn->prepare('INSERT INTO song_meaning (Artist, Trackname, Meaning, UserID) VALUES (?,?,?,?)');
	            $stmt->bind_param('sssi', $artist, $trackname, $meaning, $userID);
				$stmt->execute();
	            if ($stmt->affected_rows == 1) {
	                echo "success";
	            }
	            else echo "fail";
	        }
	        
	    }
	    $stmt->close();
	}

	// get lyrics from LyricFind API or SongAbout.fm database, merge of two database is transparent to method user
	public static function getLyrics($artist, $trackname) {
		$artist = SongInfo::normalize($artist);
		$trackname = SongInfo::normalize($trackname);
		$conn = SADatabase::getConnection();

		// http://test.lyricfind.com/api_service/lyric.do?apikey=7500cc6251b190a18374131c56a0b7f2&reqtype=default&trackid=artistname:coldplay,trackname:green+eyes&output=json&useragent=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.94 Safari/537.36

		//$url = 'http://api.lyricfind.com/search.do?apikey=1bba44bbd68a434fa9b6f155d6cff727&reqtype=default&searchtype=track&track='.$track.'&artist='.$artist.'&alltracks=no&displaykey=7500cc6251b190a18374131c56a0b7f2&output=json';
		$url = 'http://test.lyricfind.com/api_service/lyric.do?apikey=7500cc6251b190a18374131c56a0b7f2&reqtype=default&trackid=artistname:' . $artist .',trackname:'. $trackname .'&output=json&useragent=' . $_SERVER['HTTP_USER_AGENT'];

		$result = SongInfo::getCurlData($url);

		// if no result from LyricFind API, search SongAbout.fm database
		$resultJSON = json_decode($result);

		//echo SongInfo::normalize($resultJSON->{'track'}->{'title'});
		
		if ($resultJSON->{'response'}->{'code'} != 101 || SongInfo::normalize($resultJSON->{'track'}->{'title'}) != $trackname) {
			
			$result = NULL;
			
			

			// artist and track in database are all lower case and use '+' for space
			$stmt = $conn->prepare('SELECT * FROM song_lyrics WHERE Artist = ? AND Trackname = ?');
			$stmt->bind_param('ss', $artist, $trackname);
			$stmt->execute();
			$queryResult = $stmt->get_result();
			if ($queryResult->num_rows == 1)
		    {
		        $row = $queryResult->fetch_array();
		        $lyrics = $row['Lyrics'];

		        // build JSON object, should have same strcuture with LyricFind API
			    $result = json_encode(
				    array(
				    'response' => 	array(
				            			'code' => 101,
				            			'description' => 'SUCCESS: LICENSE, LYRICS',
				            			'source' => 'SONGABOUT'
				        			),
				    'track' => 	array(
				                		'title' => SongInfo::denormalize($trackname),
	      								'artist' => array(
	         										'name' => SongInfo::denormalize($artist)
	         										),
	      								'lyrics' => $lyrics
					            )
			        )
				);
		    }
		    $stmt->close();
		    
		}

		
		return $result;
	}

	public static function submitLyrics($artist, $trackname, $lyrics, $userID) {
		$artist = SongInfo::normalize($artist);
		$trackname = SongInfo::normalize($trackname);
		$conn = SADatabase::getConnection();

		$result = 'fail';

		if (!empty($artist) && !empty($trackname) && !empty($lyrics) && !empty($userID)) {
			
		    $stmt = $conn->prepare('INSERT INTO song_lyrics_queue (Artist, Trackname, Lyrics, UserID) VALUES (?,?,?,?)');
		    $stmt->bind_param('sssi', $artist, $trackname, $lyrics, $userID);
		    $stmt->execute();
		    // succesfully submitted
		    if($stmt->affected_rows == 1)
		    {
		        $result = 'success';
		    }
		}
		$stmt->close();
		return $result;
	}

	public static function verifyLyrics($accept, $submissionID) {
		$conn = SADatabase::getConnection();

		// deny
	    if ($accept == 'false') {
	        // dequeue
			$stmt = $conn->prepare('UPDATE song_lyrics_queue SET Processed = TRUE WHERE SubmissionID = ?');
			$stmt->bind_param('i', $submissionID);
			$stmt->execute();

	        // succesfully denied
	        if($stmt->affected_rows == 1)
		    {
		        echo 'success';
		    }
		    else echo 'fail';
	    } 
	    // accept
	    else if ($accept == 'true') {
	        // get meaning infomation
			$stmt = $conn->prepare('SELECT * FROM song_lyrics_queue WHERE SubmissionID = ?');
			$stmt->bind_param('i', $submissionID);
			$stmt->execute();	        
			$queryResult = $stmt->get_result();
	        $row = $queryResult->fetch_array();
	        $artist = $row['Artist'];
	        $trackname = $row['Trackname'];
	        $lyrics = $row['Lyrics'];
	        $userID = $row['UserID'];
	        $stmt->close();

	        // dequeue
			$stmt = $conn->prepare('UPDATE song_lyrics_queue SET Processed = TRUE WHERE SubmissionID = ?');
			$stmt->bind_param('i', $submissionID);
			$stmt->execute();
	        // succesfully dequeued
	        if($stmt->affected_rows != 1)
		    {
		        echo 'fail';
		    }

		    // check if meaning already exists
			$stmt = $conn->prepare('SELECT * FROM song_lyrics WHERE Artist = ? AND Trackname = ?');
			$stmt->bind_param('ss', $artist, $trackname);
			$stmt->execute();	        
			$queryResult = $stmt->get_result();


	        // if meaning already in database, replace it
	        if ($queryResult->num_rows == 1) {
				$stmt = $conn->prepare('UPDATE song_lyrics SET Lyrics = ?, UserID = ? WHERE Artist = ? AND Trackname = ?');
	            $stmt->bind_param('siss', $lyrics, $userID, $artist, $trackname);
	            $stmt->execute();
	            if ($stmt->affected_rows == 1) {
	                echo "success";
	            }
	            else echo "fail";
	        }
	        // if not, add it
	        else {
	            $stmt = $conn->prepare('INSERT INTO song_lyrics (Artist, Trackname, Lyrics, UserID) VALUES (?,?,?,?)');
	            $stmt->bind_param('sssi', $artist, $trackname, $lyrics, $userID);
				$stmt->execute();
	            if ($stmt->affected_rows == 1) {
	                echo "success";
	            }
	            else echo "fail";
	        }
	        
	    }
	    $stmt->close();
	}

	public static function submitMeta($artist, $trackname) {
		$artist = SongInfo::normalize($artist);
		$trackname = SongInfo::normalize($trackname);
		$conn = SADatabase::getConnection();

		$result = 'fail';

		if (!empty($artist) && !empty($trackname)) {
			
			$stmt = $conn->prepare('SELECT * FROM song_meta WHERE Artist = ? AND Trackname = ?');
			$stmt->bind_param('ss', $artist, $trackname);
			$stmt->execute();
			$queryResult = $stmt->get_result();

			if ($queryResult->num_rows == 1) {
				$result = 'song_exist';
			}
			else {
				$stmt = $conn->prepare('INSERT INTO song_meta (Artist, Trackname) VALUES(?, ?)');
				$stmt->bind_param('ss', $artist, $trackname);
				$stmt->execute();
				
				if($stmt->affected_rows == 1)
			    {
			        $result = 'success';
			    }
			    else $result = 'fail';
			}
   
		}

		$stmt->close();
		return $result;
	}

	public static function searchSong($trackname, $limit) {
		$trackname = SongInfo::normalize($trackname);
		$conn = SADatabase::getConnection();

		$url = 'http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $trackname .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit='.$limit;

		$result = SongInfo::getCurlData($url);

		// if no result from LastFM API, search SongAbout.fm database
		$resultJSON = json_decode($result);

		if ($resultJSON->results->{'opensearch:totalResults'} == 0) {
			$stmt = $conn->prepare('SELECT * FROM song_meta WHERE Trackname = ?');
			$stmt->bind_param('s', $trackname);
			$stmt->execute();
			$queryResult = $stmt->get_result();
			if ($queryResult->num_rows >= 1) {
				$resultJSON->results->{'opensearch:totalResults'} = min($limit, $queryResult->num_rows);
				$resultJSON->results->trackmatches = new stdClass();
				$resultJSON->results->trackmatches->track = array();

				
				$i = 0;
				while ($row = $queryResult->fetch_array()) {
					$resultJSON->results->trackmatches->track[$i] = new stdClass();
					$resultJSON->results->trackmatches->track[$i]->artist = SongInfo::denormalize($row['Artist']);
					$resultJSON->results->trackmatches->track[$i]->name = SongInfo::denormalize($row['Trackname']);
					$i++;
					if ($i >= $limit) break;
				}
				$result = json_encode($resultJSON);
			}

		}
		
		return $result;
	}

	public static function adminSignIn($password) {
		if ("admin" == $password) {
			$_SESSION['admin'] = 'true';
			echo 'success';
		}
		else echo 'fail';
	}

	public static function adminSignOut() {
		unset($_SESSION['admin']);
		echo 'success';
	}

	private static function normalize($s) {
		return strtolower(str_replace(" ","+",$s));
	}

	private static function denormalize($s) {
		return ucwords(str_replace("+"," ",$s));
	}

	private static function getCurlData($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

?>