<?php
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "addlyrics";
	$showSearch = true;	
		
	

	
	if(isset($_POST["artist"])) {
		$artistName = $_POST["artist"];
	} else {
		$artistName = "";
	}
	
	
	if(isset($_POST["song"])) {
		$songName = $_POST["song"];
	} 	
	else {
		$songName = "";
	}
	
	

	echo $artistName;
	echo $songName;
	
	
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
	
  //  	$serviceResult = getCurlData('http://api.lyricfind.com/search.do?apikey=1bba44bbd68a434fa9b6f155d6cff727
  //  	&reqtype=default&trackid=artistname:' . $artistName .',trackname:'. $songName .'&output=json&useragent=' . $_SERVER['HTTP_USER_AGENT']);
						
  // 	echo $serviceResult;
  // 	$songSearchResultsJSON = @file_get_contents($serviceResult);	
  // 	echo 'now printing json result';
  // 	echo $songSearchResultsJSON;
  
  		//$serviceResult = getCurlData('http://api.lyricfind.com/metadata.do?apikey=b28335795d6084b72f6666247ffaa09d&reqtype=metadata&displaykey=7500cc6251b190a18374131c56a0b7f2&trackid=artistname:'.$artistName. 'trackname:' .$songName);
  		//
  		// $serviceResult = getCurlData('http://api.lyricfind.com/metadata.do?apikey=b28335795d6084b72f6666247ffaa09d&reqtype=availablelyrics&artistid=amg:347307&listingtype=main&offset=0&limit=5&displaykey=7500cc6251b190a18374131c56a0b7f2');
  		
  		$artistSearchString = str_replace(" ","+",$artistName);
		$songSearchString = str_replace(" ","+",$songName);
		
		echo $artistSearchString;
		echo $songSearchString;
  		$url= 'http://api.lyricfind.com/search.do?apikey=1bba44bbd68a434fa9b6f155d6cff727&reqtype=default&searchtype=track&lyrics='.$songSearchString.'&artist='.$artistSearchString.'&alltracks=no&displaykey=7500cc6251b190a18374131c56a0b7f2&output=json';
  		echo $url;
  		$serviceResult = getCurlData($url);
  		$songSearchResultsJSON = json_decode($serviceResult);
  		$songResultCount = 0;
  		$songResultCount =$songSearchResultsJSON->totalresults;
  		echo $songResultCount;
  				for ($i =0; $i < 10; $i++) {
								$artistSongsHtml ='';
								$artistSongsHtml = $songSearchResultsJSON->tracks[$i]->title; 									
								echo $artistSongsHtml; 	
				} 
							
?>
	

<!DOCTYPE html>
<html>
<head>
	<title>Add Lyrics</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- Bootstrap -->  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <link href="styles/bootstrap.min.css" rel="stylesheet" media="screen"> 
    <script src="scripts/respond.min.js"></script>  
    <script src="//code.jquery.com/jquery.js"></script>
  	<link href="styles/lyrics.css" rel="stylesheet"/>
    <script src="scripts/bootstrap.min.js"></script>   
     <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   
  
</head>
<body>
<div class="container">
     <div class="row">
 	    <div class="col-lg-12 text-center">
 	    	<h2>Add Lyrics</h2>
 	    	  <hr class="music-primary">
                          
 	    	<br><br>
        </div>
      </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
		<form action="addlyrics.php" class="lyrics-submit" method="POST">
		<div class="row">
            <div class="form-group col-xs-5 floating-label-form-group">
            	<label for="artist">ARTIST</label>
            	<input class="form-control" type="text" name="artist" placeholder="Artist">
            </div>
            <div class="col-xs-2">
            </div>
       		<div class="form-group col-xs-5 floating-label-form-group">
                 <label for="song">SONG</label>
                 <input class="form-control" type="text" name="song" placeholder="Song">
            </div>
        </div>
        <div class="row">
        	<div class="form-group col-xs-5 floating-label-form-group">
                 <label for="albumname">ALBUM NAME</label>
                 <input class="form-control" type="text" name="albumname" placeholder="Album Name">
            </div>
             <div class="col-xs-2">
            </div>
            <div class="form-group col-xs-5 floating-label-form-group">
                 <label for="albumyear">ALBUM YEAR</label>
                 <input class="form-control" type="text" name="albumyear" placeholder="Album Year">
            </div>
        </div>
        <div class="row">
        	<div class="form-group col-xs-12 floating-radio-form-group">
                 <label for="albumname">GENRE</label></br>
                 <div class="btn-group" data-toggle="buttons">
    					<label class="btn btn-primary" >
     					   <input type="radio" name="options" id="option1">Pop
  						</label>
    					<label class="btn btn-primary">
     					   <input type="radio" name="options" id="option2">Rock
    					</label>
   						<label class="btn btn-primary">
    					    <input type="radio" name="options" id="option3">Hip-Hop
   						</label>
   						<label class="btn btn-primary">
     					   <input type="radio" name="options" id="option1">Jazz
  						</label>
    					<label class="btn btn-primary">
     					   <input type="radio" name="options" id="option2">Latin
    					</label>
   						<label class="btn btn-primary">
    					    <input type="radio" name="options" id="option3">Metal
   						</label>
   						<label class="btn btn-primary">
     					   <input type="radio" name="options" id="option2">Classical
    					</label>
   						<label class="btn btn-primary">
    					    <input type="radio" name="options" id="option3">Country
   						</label>
   						<label class="btn btn-primary">
     					   <input type="radio" name="options" id="option1">International
  						</label>
    					<label class="btn btn-primary">
     					   <input type="radio" name="options" id="option2">Other
    					</label>
   				</div>
            </div>
        </div>
        
        <div class="row">
        	<div class="form-group col-xs-12 floating-label-form-group">
                   <label for="lyrics">LYRICS</label>
                   <textarea placeholder="Lyrics" class="form-control" rows="4"></textarea>
            </div>
        </div>
         <div class="row">
        	<div class="form-group col-xs-12 floating-label-form-group">
                   <label for="lyrics">TRANSLATION in English</label>
                   <textarea placeholder="Translation in English" class="form-control" rows="4"></textarea>
            </div>
        </div>
        <br>
        <div class="row">
           <div class="form-group col-xs-12">
        	    <button type="submit" class="btn btn-lg btn-success">Submit</button>
            </div>
        </div>
	</div>
</div>
</div>
	
            
</form>
</body>
</html>
