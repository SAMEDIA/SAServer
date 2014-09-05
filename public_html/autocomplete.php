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
  $rowArray = array();
  //$url = "http://developer.echonest.com/api/v4/artist/search?api_key=NQDRAK60G9OZIAAFL&format=json&name=".$keyWord."&results=20&sort=hotttnesss-desc";
  $url = 'http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=' . $keyWord .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=20';
  //print $url . "<br>";
  $artistSearchResults = getCurlData($url);
  $artistSearchResultsJSON = json_decode($artistSearchResults);

  //statr to filter at least ten artists
  $count = 0;

  $pattern = "/feat|feat.|featuring|Feat|vs.|&|with|Ft.|ft.| VS | x |\(|Faet|\,|Vs|\;|\/|●|\+| ft |and|\|/";

  //$dataArray[] = "Artists";
  /*foreach ($artistSearchResultsJSON->{'response'}->{'artists'} as $artist) 
  {
    $artistName = $artist->{'name'};
    if ( !preg_match($pattern, $artistName)) {
      $dataArray[] = $artistName;
      $count++;
    }

    if($count  >= $artistNum)
      break;
  }*/
  foreach ($artistSearchResultsJSON->results->artistmatches->artist as &$artistSearchResultItem)
  { 
    $artistName = $artistSearchResultItem->name;
    if ( !preg_match($pattern, $artistName)) {
      $rowArray['label'] = $artistName;
      $rowArray['category'] = "Artists";
      array_push($dataArray, $rowArray);
      $count++;
    }
    if($count  >= $artistNum)
      break;
  }

  
  //append the resutls of albums
  $url = 'http://ws.audioscrobbler.com/2.0/?method=album.search&album=' . $keyWord .'&api_key=0bbac20d257fcdd508c6f4e74b75b347&format=json&limit=5';
  $albumSearchResults = getCurlData($url);
  $albumSearchResultsJSON = json_decode($albumSearchResults);
  foreach ($albumSearchResultsJSON->results->albummatches->album as &$artistSearchAlbumResultItem) 
  {
      $rowArray['label'] = $artistSearchAlbumResultItem->name;
      $rowArray['artist'] = $artistSearchAlbumResultItem->artist;
      $rowArray['category'] = "Albums";
      //$dataArray[] = $artistSearchAlbumResultItem->name . "--" . $artistSearchAlbumResultItem->artist;
      array_push($dataArray, $rowArray);
  }

  //append the results of songs 
  $url = 'http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $keyWord .'&api_key=bd7041ea682d4751dc24efa6765ede9d&format=json&limit=5';
  $songSearchResults = getCurlData($url);
  $songSearchResultsJSON = json_decode($songSearchResults);
  foreach ($songSearchResultsJSON->results->trackmatches->track as &$songSearchResultItem) {
    $artistname = $songSearchResultItem->artist;
    $songname = $songSearchResultItem->name;
   
    $rowArray['label'] = $songname;
    $rowArray['artist'] = $artistname; 
    $rowArray['category'] = 'Songs';
    array_push($dataArray, $rowArray);
  }

  echo json_encode($dataArray);
?>
