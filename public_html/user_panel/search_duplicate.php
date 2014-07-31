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

$artist = $_POST["artist"];
$song = $_POST["song"];

$artist = str_replace(" ","+",$artist);
$song = str_replace(" ","+",$song);

$url= 'http://api.lyricfind.com/search.do?apikey=1bba44bbd68a434fa9b6f155d6cff727&reqtype=default&searchtype=track&track='.$song.'&artist='.$artist.'&alltracks=no&displaykey=7500cc6251b190a18374131c56a0b7f2&output=json';

$serviceResult = getCurlData($url);

echo $serviceResult;

//$songSearchResultsJSON = json_decode($serviceResult);
//echo $songSearchResultsJSON->response->description;

?>