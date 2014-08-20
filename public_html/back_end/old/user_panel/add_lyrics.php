<!DOCTYPE html>
<html>
<head>
    <title>Add Lyrics</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- Bootstrap -->  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>   
    <!--<script src="scripts/respond.min.js"></script>  -->
    <link href="lyrics.css" rel="stylesheet"/>
    <link href="font-awesome.min.css" rel="stylesheet" type="text/css">
   
  
</head>
<body>


<?php

include "../user_panel/connect_database.php";
if (!isset($_SESSION)) { session_start(); }

if (!empty($_SESSION['loggedIn']))
{
    // user already logged in
    // show brief user information
    echo '<p>You have logged in! Nickname : <code>';
    echo $_SESSION['nickname'];
    echo '</code> Email : <code>';
    echo $_SESSION['email'];
    echo '</code></p>';
    ?>

    <a href="" id="signOutLink">Sign Out</a><br>

    <script>
    // Ajax Sign Out
    $(document).ready(function(){
        $("#signOutLink").click(function(){
            $.post('../user_panel/sign_out.php', function(data,status){
                if (data=="success") {
                    $("head").append('<meta http-equiv="refresh" content="2;../user_panel/index_test.php">');    
                }
            });
        });
    });
    </script>

    <?php
}
else
{
    // if user not logged in, redirect to homepage
    ?>
    <script>
    $(document).ready(function(){
        $("body").html('<h1 style="color:red">You are not logged in! Redirecting..</h1>');
        $("head").append('<meta http-equiv="refresh" content="2;../user_panel/index_test.php">');
    });
    </script>
<?php
}
	
	if(isset($_POST["artist"])) {
		$artistName = $_POST["artist"];
	} else {
		$artistName = "coldplay";
	}
	
	
	if(isset($_POST["song"])) {
		$songName = $_POST["song"];
	} 	
	else {
		$songName = "Yellow";
	}

    // if directed from the song page, no need for checking duplicates
			
?>
	

<!DOCTYPE html>
<html>
<head>
	<title>Add Lyrics</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- Bootstrap -->  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>   
    <!--<script src="scripts/respond.min.js"></script>  -->
    <link href="lyrics.css" rel="stylesheet"/>
    <link href="font-awesome.min.css" rel="stylesheet" type="text/css">
   
    <script>
    // Ajax Search Lyrics to prevent duplication

    // a delay function that delays the search for some time after the user type in
    var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
    })();
    
    
    $(document).ready(function(){
        // hide the new lyrics fields(album, lyrics, etc) first, user can't add lyrics without checking duplicates
        $("#newLyrics").hide();
        
        // search for duplicates
        $("#artist").keyup(function(){
            delay(function(){
                var artist = $("#artist").val();
                var song = $("#song").val();

                $.post('../user_panel/search_duplicate.php', {'artist':artist, 'song':song}, function(data){
                    var dataJSON = $.parseJSON(data);
                    $("#searchDuplicateResult").html('<h2>Help us precent duplicate songs</h2>result:'+dataJSON.totalresults+"<br><ol></ol>");
                    for (var i = 0; i < dataJSON.totalresults && i < 10; i++) {
                        $("#searchDuplicateResult ol").append('<li>'+dataJSON.tracks[i].title+'</li>');
                    }
                    $("#searchDuplicateResult").append('<button class="btn btn-lg btn-success" id="addLyricsButton">None of these, add new lyrics!</button>');
                });
            }, 300 );
        });
        // add the same hahavior for both artist and song input 
        $("#song").keyup(function(){
            delay(function(){
                var artist = $("#artist").val();
                var song = $("#song").val();

                $.post('../user_panel/search_duplicate.php', {'artist':artist, 'song':song}, function(data){
                    var dataJSON = $.parseJSON(data);
                    $("#searchDuplicateResult").html('<h2>Help us precent duplicate songs</h2>result:'+dataJSON.totalresults+"<br><ol></ol>");
                    for (var i = 0; i < dataJSON.totalresults && i < 10; i++) {
                        $("#searchDuplicateResult ol").append('<li>'+dataJSON.tracks[i].title+'</li>');
                    }
                    $("#searchDuplicateResult").append('<button class="btn btn-lg btn-success" id="addLyricsButton">None of these, add new lyrics!</button>');
                });
            }, 300 );
        });
        // add new lyric button handler, show the lyrics and song info form for user to fill up
        $(document).on("click","#addLyricsButton",function(){ 
            $("#searchDuplicateResult").hide();
            $("#newLyrics").show();
        });
        // submit new lyrics to database
        $("#submitLyricsButton").click(function(){
            
            var artist = $("#artist").val();
            var song = $("#song").val();
            var album = $("#album").val();
            var year = $("#year").val();
            var genre = $('input[name=options]:checked').val();
            var lyrics = $("#lyrics").val();
            // check form
            var check = true;
            if (artist == "") {
                $("#newLyrics").append("<h1>artist is required!</h1>");
                check = false;
            }
            if (song == "") {
                $("#newLyrics").append("<h1>song name is required!</h1>");
                check = false;
            }
            if (lyrics == "") {
                $("#newLyrics").append("<h1>lyrics is required!</h1>");
                check = false;
            }
            if (check == true) {
                //$("#newLyrics").append("<h1>"+artist+" "+song+" "+album+" "+year+" genre:"+genre+" "+lyrics+"</h1>");
                if (genre == null) {
                    //$("#newLyrics").append("<h1>genre is required!</h1>");
                    // set genre to empty string, instead of null
                    genre = "";
                }
                $.post('add_lyrics_sql.php', {'artist':artist, 'song':song, 'album':album, 'year':year, 'genre':genre, 'lyrics':lyrics}, function(data){
                    $("#newLyrics").append(data);
                    
                    if (data == "success") {
                        $("#newLyrics").append("<h1>lyrics added! redirecting...</h1>").css("color","green");
                        //$("head").append('<meta http-equiv="index_test.php" content="2">');
                    } else {
                        $("#newLyrics").append("<h1>Something goes wrong with adding lyrics into the data base!</h1>").css("color","red");
                    }
                    
                });
            }
        });
    });
    </script>
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
		<!--<form action="addlyrics.php" class="lyrics-submit" method="POST">-->
		<div class="row">
            <div class="form-group col-xs-5 floating-label-form-group">
            	<label for="artist">ARTIST</label>
            	<input class="form-control" type="text" id="artist" name="artist" placeholder="Artist" autocomplete="off">
            </div>
            <div class="col-xs-2">
            </div>
       		<div class="form-group col-xs-5 floating-label-form-group">
                 <label for="song">SONG</label>
                 <input class="form-control" type="text" id="song" name="song" placeholder="Song" autocomplete="off">
            </div>
        </div>
        <div id="searchDuplicateResult">
            
        </div>
        <div id="newLyrics">
            <div class="row">
            	<div class="form-group col-xs-5 floating-label-form-group">
                     <label for="album">ALBUM</label>
                     <input class="form-control" type="text" id="album" name="album" placeholder="Album">
                </div>
                 <div class="col-xs-2">
                </div>
                <div class="form-group col-xs-5 floating-label-form-group">
                     <label for="year">YEAR</label>
                     <input class="form-control" type="text" id="year" name="year" placeholder="Year">
                </div>
            </div>
            <div class="row">
            	<div class="form-group col-xs-12 floating-radio-form-group">
                     <label for="albumname">GENRE</label></br>
                     <div class="btn-group" data-toggle="buttons">
        					<label class="btn btn-primary" >
         					   <input type="radio" name="options" value="Pop" id="option1">Pop
      						</label>
        					<label class="btn btn-primary">
         					   <input type="radio" name="options" value="Rock" id="option2">Rock
        					</label>
       						<label class="btn btn-primary">
        					    <input type="radio" name="options" value="Hip-Hop" id="option3">Hip-Hop
       						</label>
       						<label class="btn btn-primary">
         					   <input type="radio" name="options" value="Jazz" id="option1">Jazz
      						</label>
        					<label class="btn btn-primary">
         					   <input type="radio" name="options" value="Latin" id="option2">Latin
        					</label>
       						<label class="btn btn-primary">
        					    <input type="radio" name="options" value="Metal" id="option3">Metal
       						</label>
       						<label class="btn btn-primary">
         					   <input type="radio" name="options" value="Classical" id="option2">Classical
        					</label>
       						<label class="btn btn-primary">
        					    <input type="radio" name="options" value="Country" id="option3">Country
       						</label>
       						<label class="btn btn-primary">
         					   <input type="radio" name="options" value="International" id="option1">International
      						</label>
        					<label class="btn btn-primary">
         					   <input type="radio" name="options" value="Other" id="option2">Other
        					</label>
       				</div>
                </div>
            </div>
            
            <div class="row">
            	<div class="form-group col-xs-12 floating-label-form-group">
                       <label for="lyrics">LYRICS</label>
                       <textarea placeholder="Lyrics" class="form-control" rows="10" id="lyrics"></textarea>
                </div>
            </div>
            <!--
             <div class="row">
            	<div class="form-group col-xs-12 floating-label-form-group">
                       <label for="lyrics">TRANSLATION in English</label>
                       <textarea placeholder="Translation in English" class="form-control" rows="4"></textarea>
                </div>
            </div>
            -->
            <br>
            <div class="row">
               <div class="form-group col-xs-12">
            	    <button type="submit" class="btn btn-lg btn-success" id="submitLyricsButton">Submit</button>
                </div>
            </div>

        </div>
	</div>
</div>
</div>
	
            
<!--</form>-->
</body>
</html>
