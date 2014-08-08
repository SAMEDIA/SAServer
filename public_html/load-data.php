<?php

if (!isset($_GET['page'])) exit;
if (!isset($_GET['category'])) exit;
if (!isset($_GET['query'])) exit;

$page = $_GET['page'];
$category = $_GET['category'];
$currentSearchString = $_GET['query'];

$array = array();
$resultHtml = '';

//set the url first
switch ($category) {
	case 'albums':
		$url = 'http://ws.audioscrobbler.com/2.0/?method=album.search&album=' . $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=30&page=' . $page;
		break;
	case 'songs':
		$url = 'http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=30&page=' . $page;
		break;
	default:
		break;
}

if($category == "songs")
{
	$songSearchResults=getCurlData($url);
	$songSearchResultsJSON = json_decode($songSearchResults);

	$totalNum = $songSearchResultsJSON->results->{'opensearch:totalResults'};

	//if($page > $totalNum / 30);
		//break;

	$count = ($page - 1 ) * 30;
	foreach ($songSearchResultsJSON->results->trackmatches->track as &$songSearchResultItem) {
		
		$artistname = $songSearchResultItem->artist;
		$artistname = '"'. $artistname . '"';
			
		$artistname =  json_decode($artistname);

		/*$resultHtml .= '<div class="left suggestedArtistItem">';

		$resultHtml .= '<div class="songItemTitle left">';
		$resultHtml .= '<a href="./song-detail.php?songName=' .$songSearchResultItem->name. '&artistName='. $artistname . '">';
		$resultHtml .= $songSearchResultItem->name . '</a><br>';
		$resultHtml .= '<span class="songItemTitleFootnote">'. $artistname .'</span></br>';	
		$resultHtml .= "</div>";
		$resultHtml .= "</div>";*/

		$count = $count + 1;
		$resultHtml .= "<tr>";
		$resultHtml .= "<td>" . $count . "</td>";
		/*if ($songSearchResultItem->image[1]->{'#text'} != "")
			$resultHtml .= "<td><img border='0' height='60' width='60' src='" . $songSearchResultItem->image[1]->{'#text'} . "'></td>";
		else
			$resultHtml .= "<td><img border='0' height='60' width='60' src='" . $songSearchResultItem->image[0]->{'#text'} . "'></td>";*/
		$resultHtml .= "<td>";
		$resultHtml .= "<a href='./song-detail.php?songName=" .$songSearchResultItem->name. "&artistName=". $artistname . "'>";
		$resultHtml .= $songSearchResultItem->name . "</a></td>";
		$resultHtml .= "<td><p class='songItemTitleFootnote'>". $artistname ."</p>";
		$resultHtml .= "</td></tr>";
	}
}

if($category == "albums")
{
	$albumSearchResults = getCurlData($url);
	$albumSearchResultsJSON = json_decode($albumSearchResults);

	$totalNum = $albumSearchResultsJSON->results->{'opensearch:totalResults'};

	foreach ($albumSearchResultsJSON->results->albummatches->album as &$artistSearchAlbumResultItem) 
	{
		$artistname = $artistSearchAlbumResultItem->artist;
		$artistname = json_decode('"' . $artistname . '"');

		$resultHtml .= "<div class='albumItem col-md-2 col-sm-4 col-xs-6' style='height:240;'>";	
		if ($artistSearchAlbumResultItem->image[3]->{'#text'} != "")
			$resultHtml .= "<div class='albumImg'><img src='" . $artistSearchAlbumResultItem->image[3]->{'#text'}  . "' border='0' style='height:160;width:160;'></div>";
		else 
			$resultHtml .= "<div class='albumImg'><img src='" . $artistSearchAlbumResultItem->image[1]->{'#text'}  . "' border='0' style='height:160;width:160;'></div>";
		$resultHtml .= '<span class="albumItemTitleFootnote"><strong><a href="./album-detail.php?albumName=' . $artistSearchAlbumResultItem->name .'&artistName=' . $artistname .'">'. $artistSearchAlbumResultItem->name .'</a></strong><br>' . $artistname . "</span>";
		$resultHtml .= "</div>";

	}			
}



array_push($array, $resultHtml);

echo json_encode($array);


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
?>