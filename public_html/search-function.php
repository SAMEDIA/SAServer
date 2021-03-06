<?php

class searchControler
{
	public function getCurrentSearchString()
	{
		if(isset($_GET["search"])) {
			$currentSearchString = $_GET["search"];
			$currentSearchString = trim($currentSearchString);
			$currentSearchString = str_replace(" ","+",$currentSearchString);
			//$currentSearchStringEchonest = str_replace(" ","-",$_GET["search"]);
		} else if(isset($_POST["search"])) 
		{
			$currentSearchString = $_POST["search"];
			$currentSearchString = trim($currentSearchString);
			$currentSearchString = str_replace(" ","+",$currentSearchString);
			//$currentSearchStringEchonest = str_replace(" ","-",$_POST["search"]);
		}
		return $currentSearchString;

	}

	public function printCategory($currentSearchString, $category)
	{
		echo "<ul class='nav nav-tabs nav-justified' role='tablist'>";
		if ($category == "all")
			echo "<li class='active'>";
		else
			echo "<li>";
 		echo "<a href=\"./search.php?category=all&search=". $currentSearchString ."\">All</a>";
 		echo "</li>";

 		if ($category == "artists") 
			echo "<li class='active'>";
		else
			echo "<li>";
 		echo "<a href=\"./search.php?category=artists&search=". $currentSearchString ."\">Artists</a></li>";

 		if ($category == "albums") 
			echo "<li class='active'>";
		else
			echo "<li>";
		echo "<a href=\"./search.php?category=albums&page=1&search=". $currentSearchString ."\">Albums</a></li>";

		if ($category == "songs") 
			echo "<li class='active'>";
		else
			echo "<li>";
		echo "<a href=\"./search.php?category=songs&page=1&search=". $currentSearchString ."\">Songs</a></li>";
		echo "</ul>";

		echo "<div class='container-fluid' >";

	}

	private function getCurlData($url) {
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}

	

	public function searchArtist($num,$currentSearchString)
	{
		$count = 0;
		$page = 1;


		//make sure to show max number search result, 5 for front page and 30 for search results page
		//get the first 90 search results to fill the 5 or 30 results. if can not fill, simply leave it.
		while ($page <= 3) 
		{
			if($count >= $num)
				break;

			$url = 'http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=' . $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=30&page=' . $page;
			
			
			$artistSearchResults = $this->getCurlData($url);
			$artistSearchResultsJSON = json_decode($artistSearchResults);
			// If artist search does not return results loop through the search string spaces to find artist
			if(isset($artistSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($artistSearchResultsJSON->results->{'opensearch:totalResults'}) && $artistSearchResultsJSON->results->{'opensearch:totalResults'} != 0) {
				$artistResultCount = $artistSearchResultsJSON->results->{'opensearch:totalResults'};
				//echo $artistResultCount;
			} else {
				/*$artistSearchStrings = explode("+", $currentSearchString);
				foreach($artistSearchStrings as $artistSearchString) {
					$artistSearchResults = $this->getCurlData('http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=' . $artistSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit='.$num);
					$artistSearchResultsJSON = json_decode($artistSearchResults);
					if(isset($artistSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($artistSearchResultsJSON->results->{'opensearch:totalResults'})) {
						$artistResultCount = $artistSearchResultsJSON->results->{'opensearch:totalResults'};
						break;	
					}
				}*/
			}

			//not show on font page
			
	        //filter "."  "feat" "FT" "&" "(" "[" "VS" "&" 
	        $pattern = "/feat|feat.|featuring|Feat|vs.|&|with|Ft.|ft.| VS | x |\(|Faet|\,|Vs|\;|\/|●|\+| ft |and|\|/";

			if(isset($artistResultCount) && $artistResultCount > 0) 
			{

				foreach ($artistSearchResultsJSON->results->artistmatches->artist as &$artistSearchResultItem)
				{	
					
					
					$currentArtistName = $artistSearchResultItem->name;
					
					if($artistResultCount == 1 and isset($artistSearchResultsJSON->results->artistmatches->artist->name)) {
						$currentArtistName = $artistSearchResultsJSON->results->artistmatches->artist->name;
					}
					if($currentArtistName != "" && !preg_match($pattern, $currentArtistName) && $artistSearchResultItem->image[3]->{'#text'} != "") 
					{
						
						$currentArtistName = json_decode('"' . $currentArtistName .'"');
			
						$artistResultHtml .= "<div class='albumItem col-md-2 col-sm-4 col-xs-6 col-md-height'>";
						$artistResultHtml .= "<div class='imageContainer'>";
						$artistResultHtml .= "<div class='imageCenterer'>";
						$artistResultHtml .= "<div class='albumImg'><img class='lazy' data-original='" . $artistSearchResultItem->image[2]->{'#text'}  . "' border='0' width='125' height='125'></div>";
						$artistResultHtml .= '</div>';
						$artistResultHtml .= '</div>';
						$artistResultHtml .= '<span class="artistItemTitle">';	
						$artistResultHtml .= '<a href="./artist-detail.php?artistName='. $currentArtistName .'">';
						$artistResultHtml .=  $currentArtistName . '</a><br>';
						$artistResultHtml .= '</span>';
						$artistResultHtml .= '</div>';
						$count++;
						
						if($count >= $num)
							break;
					}			

				}
			}
			else
			{
				break;
			}

			$page++;
				
		}
		$this->printSearchArtistResults($count, $currentSearchString, $artistResultHtml);
	}

	private function printSearchArtistResults($count, $currentSearchString, $artistResultHtml)
	{
        echo "<div id='ArtistSearchResults' class='col-md-12'>";
 		echo "<div class='row'>";
		echo "<div id='header' class='col-md-10'>";
 		echo "<h2 class='sub-header'>Artists</h2></div>";
 		echo "<div id='more-results' class='col-md-2'>";
 		if ($count == 6) {
        	echo "<h3 class='text-right'><a href=\"./search.php?category=artists&page=1&search=". $currentSearchString ."\">more</a></h3>";	
        }
        echo "</div>";  
        echo "</div>";
 		if ($count == 0) 
 		{
 			echo "No Results Found";
 		}
 		else
 		{
 			echo $artistResultHtml;
 		}
 		echo "</div>";
	}  	



	public function searchAlbum($num,$currentSearchString)
	{
		$albumSearchResults = $this->getCurlData('http://ws.audioscrobbler.com/2.0/?method=album.search&album=' . $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit='.$num . "&page=" . $page);	
		$albumSearchResultsJSON = json_decode($albumSearchResults);

		if(isset($albumSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($albumSearchResultsJSON->results->{'opensearch:totalResults'})) {
			$albumResultCount = $albumSearchResultsJSON->results->{'opensearch:totalResults'};
			//echo $albumResultCount;
		} else {
			//echo '0';	
		}

		$count = 0;

		if(isset($albumResultCount) && $albumResultCount > 0) {
			foreach ($albumSearchResultsJSON->results->albummatches->album as &$artistSearchAlbumResultItem) {
				if($artistSearchAlbumResultItem->image[3]->{'#text'} != "") {


					$artistname = $artistSearchAlbumResultItem->artist;
					$artistname = json_decode('"' . $artistname . '"');
			
					$artistAlbumsHtml .= "<div class='albumItem col-md-2 col-sm-4 col-xs-6'>";	
					$artistAlbumsHtml .= "<div class='albumImg'><img class='lazy' data-original='" . $artistSearchAlbumResultItem->image[2]->{'#text'}  . "' border='0'></div>";
					//$artistAlbumsHtml .= "<div class='caption'>";
					$artistAlbumsHtml .= '<span class="albumItemTitleFootnote"><strong><a href="./album-detail.php?albumName=' . $artistSearchAlbumResultItem->name .'&artistName=' . $artistname .'">'. $artistSearchAlbumResultItem->name .'</a></strong><br>' . $artistname . "</span>";
					//$artistAlbumsHtml .= "</div>";
					//$artistAlbumsHtml .= "</div>";
					$artistAlbumsHtml .= "</div>";
					$count++;
					if($count >= $num) {
						break;	
					}
				}										
			}
			
		} 

		$this->printAblumSearchResult($count, $currentSearchString, $artistAlbumsHtml);
		
	}


	private function printAblumSearchResult($count, $currentSearchString, $artistAlbumsHtml)
	{
		echo "<div id='AlbumSearchResults' class='col-md-12'>";
 		echo "<div class='row'>";
		echo "<div id='header' class='col-md-10'>";
 		echo "<h2 class='sub-header'>Albums</h2></div>";
 		echo "<div id='more-results' class='col-md-2'>";
 		if ($count == 6) {
        	echo "<h3 class='text-right'><a href=\"./search.php?category=albums&page=1&search=". $currentSearchString ."\">more</a></h3>";	
        }
        echo "</div>";  
        echo "</div>";
 		if ($count == 0)
 		{
 			echo "No Results Found";
 		}
 		else
 		{
 			echo $artistAlbumsHtml;
 		}
 		echo "</div>";
		if($count == 30)
		{	
			//echo "<span id='loadmore' page='2' category='ablums'>Load More</span>";
			echo "<div class='col-md-12 text-center'>";
			echo "<button type='button' id='loadmore' data-loading-text='Loading...' class='btn btn-primary' page='2' category='albums'
					style='width: 90%;margin-bottom: 20'>
 				 Load More
			</button>";
			echo "</div>";
		}
       	
	}

	public function searchSongs($num,$currentSearchString)
	{
		$count = 0;

		// search both LastFM and SongAbout.fm database
		//require_once "back_end/SongInfo.php";
		//$songSearchResults = SongInfo::searchSong($currentSearchString, $num);
		
		// search only LastFM database
		$songSearchResults = $this->getCurlData('http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit='.$num);
		

		$songSearchResultsJSON = json_decode($songSearchResults);

		if(isset($songSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($songSearchResultsJSON->results->{'opensearch:totalResults'})) {
			$songResultCount = $songSearchResultsJSON->results->{'opensearch:totalResults'};
			//echo $songResultCount;
		} else {
			//echo '0';	
		}
		
		if(isset($songResultCount) && $songResultCount > 0) {
			foreach ($songSearchResultsJSON->results->trackmatches->track as &$songSearchResultItem) {
				
				$artistname = $songSearchResultItem->artist;

				$artistname = '"'. $artistname . '"';
					
				$artistname =  json_decode($artistname);

				$artistSongsHtml .= "<tr>";
				$artistSongsHtml .= "<td>" . ($count+1) . "</td>";
				$artistSongsHtml .= "<td>";
				$artistSongsHtml .= "<a href='./song-detail.php?songName=" .$songSearchResultItem->name. "&artistName=". $artistname . "'>";
				$artistSongsHtml .= $songSearchResultItem->name . '</a>';
				$artistSongsHtml .= "</td>";
				$artistSongsHtml .= "<td><p class='songItemTitleFootnote'>". $artistname ."</p></td>";
				$artistSongsHtml .= "</tr>";
				$count++;
				
			} 
			
	
		}
		
		$this->printSongSearchResults($count, $currentSearchString, $artistSongsHtml);
		
	}

	private function printSongSearchResults($count, $currentSearchString, $artistSongsHtml)
	{

		echo "<div id='ArtistSearchResults' class='col-md-12'>";
		echo "<div class='row'>";
		echo "<div id='header' class='col-md-10'>";
 		echo "<h2 class='sub-header'>Songs</h2></div>";
 		echo "<div id='more-results' class='col-md-2'>";
 		if ($count == 10) {
        	echo "<h3 class='text-right'><a href=\"./search.php?category=songs&page=1&search=". $currentSearchString ."\">more</a></h3>";	
        }
        echo "</div>";  
        echo "</div>";
  		echo "<div class='table-responsive'>";
  		echo "<table class='table table-striped'>
      			<thead>
        			<tr>
        			</tr>
      			</thead>
      			<tbody>";
      	if ($count != 0) {
      		echo $artistSongsHtml;
      	}
      	else
      	{
      		echo "No Results Found";
      	}
      	echo " 	</tbody>
    		 </table>";
  		echo "</div>";
  		echo "</div>";
  		if($count > 10)
		{	
			//echo "<span id='loadmore' page='2' category='songs' align='center'>Load More</span>";
			echo "<div class='col-md-12 text-center'>";
			echo "<button type='button' id='loadmore' data-loading-text='Loading...' class='btn btn-primary' page='2' category='songs'
					style='width: 90%;margin-bottom: 20'>
 				 Load More
			</button>";
			echo "</div>";
		}
	}

}

?>