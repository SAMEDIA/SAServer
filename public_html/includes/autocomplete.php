<?php
  function getCurlData($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  } 

  $artistNum = 5;

  $keyWord = $_REQUEST['term'];
 
  $keyWord = trim($keyWord);
  $keyWord = str_replace(" ", "+", $keyWord);
  //$keyWord = str_replace(" ", "", $keyWord);
  $dataArray = array();

  $url = "http://developer.echonest.com/api/v4/artist/search?api_key=NQDRAK60G9OZIAAFL&format=json&name=".$keyWord."&results=20&sort=hotttnesss-desc";
  //print $url . "<br>";
  $artistSearchResults = getCurlData($url);
  $artistSearchResultsJSON = json_decode($artistSearchResults);

  //statr to filter at least ten artists
  $count = 0;

  $pattern = "/feat|feat.|featuring|Feat|vs.|&|with|Ft.|\(|Faet|\,|Vs|\;|\/|●|\+| ft |and|\|/";


  foreach ($artistSearchResultsJSON->{'response'}->{'artists'} as $artist) 
  {
    $artistName = $artist->{'name'};
    if ( !preg_match($pattern, $artistName)) {
      $dataArray[] = $artistName;
      $count++;
    }

    if($count  >= $artistNum)
      break;
  }

  //append the resutls of albums
  $url = 'http://ws.audioscrobbler.com/2.0/?method=album.search&album=' . $keyWord .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=5';
  $albumSearchResults = getCurlData($url);
  $albumSearchResultsJSON = json_decode($albumSearchResults);
  foreach ($albumSearchResultsJSON->results->albummatches->album as &$artistSearchAlbumResultItem) 
  {
      $dataArray[] = $artistSearchAlbumResultItem->name . "--" . $artistSearchAlbumResultItem->artist;
  }

  //append the results of songs 

  $url = 'http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $keyWord .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=5';
  $songSearchResults = getCurlData($url);
  $songSearchResultsJSON = json_decode($songSearchResults);
  foreach ($songSearchResultsJSON->results->trackmatches->track as &$songSearchResultItem) {
    $artistname = $songSearchResultItem->artist;
    $songname = $songSearchResultItem->name;
    $data = $songname . "--" . $artistname;
    
    $dataArray[] = $data;
  }

  echo json_encode($dataArray);
?>
