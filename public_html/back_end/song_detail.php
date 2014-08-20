<!-- load jQuery if not available -->
<script>
  window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.11.0.min.js"><\/script>')
</script>

<?php
// load models
require_once "SongInfo.php";

if (!isset($_SESSION)) { session_start(); }

echo '<h1>Song Detail</h1>';

if (!empty($_GET['artistName']) && !empty($_GET['songName'])) {
    $artist = $_GET['artistName'];
    $trackname = $_GET['songName'];
    echo '<p class="frame">';
    echo 'Artist: '.$artist.'<br>';
    echo 'Track: '.$trackname.'<br>';
    echo '</p>';

    // song meaning
    echo 'Meaning: <br>';
    echo '<p class="frame">';
    $meaning = SongInfo::getMeaning($artist, $trackname);
    if ($meaning != NULL) {
        echo $meaning;
    }
    else {
        echo 'There is no meaning for this song.';
    }

    echo '<br>';
    if ($user->loggedIn()) {
        ?>

        <a href="" data-toggle="modal" data-target="#meaningSubmitModal">Submit My Meaning</a>
        

        <script>
        // Ajax Submit Meaning
        $(document).ready(function(){
            $("#meaningSubmitButton").click(function(){
                var userID = <?php echo $user->getID() ?>;
                var artist = '<?php echo $artist ?>';
                var trackname = '<?php echo $trackname ?>';
                var meaning = $("#meaning").val();
                //$("#result").html("<h1>"+userID+" "+artist+" "+trackname+" "+meaning+"</h1>");
                $.post('SongInfo_controller.php', {'action':'submitMeaning', 'artist':artist, 'trackname':trackname, 'meaning':meaning, 'userID':userID}, function(data,status){
                    if ("success" == data) {
                        $("#meaningResult").html("Meaning Submitted!").css('color','green');
                        $("head").append('<meta http-equiv="refresh" content="2">');    
                    }
                    else {
                        $("#meaningResult").html("Submission failed!").css("color","red");
                    }
                });
            });
        });
        </script>

        <!-- Bootstrap Modal Meaning Submission -->
        <div class="modal fade" id="meaningSubmitModal" tabindex="-1" role="dialog" aria-labelledby="meaningSubmitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="meaningSubmitModalLabel">Submit My Meaning</h4>
                        <p style="color:gray">You will get notified whether your meaning is approved to be displayed for the song!</p>
                    </div>
                    <div class="modal-body">

                        <label for="meaning">Meaning:</label>
                        <textarea placeholder="Meaning" class="form-control" rows="10" id="meaning" name="meaning"></textarea>

                        <input type="submit" class="btn btn-primary" id="meaningSubmitButton" value="Submit" name="submit">
                        <p id="meaningResult"></p>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    else {
        echo '<br>Sign in to submit your own meaning!';
    }

    echo '</p>';


    // song lyrics
    echo 'Lyrics: <br>';
    echo '<p class="frame">';
    $lyrics = SongInfo::getLyrics($artist, $trackname);
    //echo $lyrics;
    
    if ($lyrics != NULL) {
        
        $songLyricsJSON = json_decode($lyrics); 
        //echo $lyrics;
        

        if (!empty($songLyricsJSON->response->source) && $songLyricsJSON->response->source == 'SONGABOUT')
            echo 'Lyrics from SongAbout.fm<br><br>';
        else echo 'Lyrics from LyricFind<br><br>';

        echo nl2br($songLyricsJSON->track->lyrics);
        
        
    }
    else {

        echo 'There is no lyrics for this song.';
    }
    

    echo '<br>';
    if ($user->loggedIn()) {
        ?>

        <a href="" data-toggle="modal" data-target="#lyricsSubmitModal">Submit My Lyrics</a>
        

        <script>
        // Ajax Submit Lyrics
        $(document).ready(function(){
            $("#lyricsSubmitButton").click(function(){
                var userID = <?php echo $user->getID() ?>;
                var artist = '<?php echo $artist ?>';
                var trackname = '<?php echo $trackname ?>';
                var lyrics = $("#lyrics").val();
                
                $.post('SongInfo_controller.php', {'action':'submitLyrics', 'artist':artist, 'trackname':trackname, 'lyrics':lyrics, 'userID':userID}, function(data,status){
                    if ("success" == data) {
                        $("#lyricsResult").html("Lyrics Submitted!").css('color','green');
                        $("head").append('<meta http-equiv="refresh" content="2">');
                    }
                    else {
                        $("#lyricsResult").html("Submission failed!").css("color","red");
                    }
                });
            });
        });
        </script>

        <!-- Bootstrap Modal Lyrics Submission -->
        <div class="modal fade" id="lyricsSubmitModal" tabindex="-1" role="dialog" aria-labelledby="lyricsSubmitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="lyricsSubmitModalLabel">Submit My Lyrics</h4>
                        <p style="color:gray">You will get notified whether your lyrics is approved to be displayed for the song!</p>
                    </div>
                    <div class="modal-body">

                        <label for="lyrics">Lyrics:</label>
                        <textarea placeholder="Lyrics" class="form-control" rows="10" id="lyrics" name="lyrics"></textarea>

                        <input type="submit" class="btn btn-primary" id="lyricsSubmitButton" value="Submit" name="submit">
                        <p id="lyricsResult"></p>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    else {
        echo '<br>Sign in to submit your own lyrics!';
    }

    echo '</p>';
}


?>