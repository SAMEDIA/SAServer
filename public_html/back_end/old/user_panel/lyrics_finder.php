<?php

class LyricsFinder {
	public static function getLyrics($artist, $track) {

		$artist = strtolower(str_replace(" ","+",$artist));
		$track = strtolower(str_replace(" ","+",$track));

		//$url = 'http://api.lyricfind.com/search.do?apikey=1bba44bbd68a434fa9b6f155d6cff727&reqtype=default&searchtype=track&track='.$track.'&artist='.$artist.'&alltracks=no&displaykey=7500cc6251b190a18374131c56a0b7f2&output=json';
		$url = 'http://test.lyricfind.com/api_service/lyric.do?apikey=7500cc6251b190a18374131c56a0b7f2&reqtype=default&trackid=artistname:' . $artist .',trackname:'. $track .'&output=json&useragent=' . $_SERVER['HTTP_USER_AGENT'];

		$result = LyricsFinder::getCurlData($url);

		
		$resultJSON = json_decode($result);
		// if return no result, search SongAbout.fm database
		if ($resultJSON->{'response'}->{'code'} != 101) {
			//echo $resultJSON->{'track'}->{'title'};
			include "../user_panel/connect_database.php";
			// artist and track in database are all lower case and use '+' for space
			$queryResult = mysql_query("SELECT * FROM songs WHERE Artist = '".$artist."' AND Trackname = '".$track."'");
			
			if (mysql_num_rows($signInQueryResult) == 1)
			if (true)
		    {
		        $row = mysql_fetch_array($signInQueryResult);
		        $lyrics = $row['Lyrics'];
		        //$lyrics = "lyrics lyrics\nlyrics lyrics\n\nlyrics lyrics lyrics lyrics\nlyrics lyrics\n";

		        // build JSON object, should have same strcuture with LyricFind API
			    $result = json_encode(
				    array(
				    'response' => 	array(
				            			'code' => 101,
				            			'description' => 'SUCCESS: LICENSE, SONGABOUT'
				        			),
				    'track' => 	array(
				                		'title' => $track,
	      								'artist' => array(
	         										'name' => $artist
	         										),
	      								'lyrics' => $lyrics
					            )
			        )
				);
		    }
		    
		}
		
		return $result;
		

		
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