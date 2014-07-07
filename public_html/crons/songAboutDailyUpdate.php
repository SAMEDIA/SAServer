<?php
	require_once '../songabout_lib/models/PopularSongCache.php';
	require_once '../songabout_lib/models/PopularArtistCache.php';

	$topSongObj = new PopularSongCache();
	$topSongObj->updateDailyData();
	
	$topArtistsObj = new PopularArtistCache();
	$topArtistsObj->updateDailyData();

?>