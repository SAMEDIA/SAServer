<!-- load jQuery if not available -->
<script>
  window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.11.0.min.js"><\/script>')
</script>

<?php
// load models
require_once "SongInfo.php";

if (!isset($_SESSION)) { session_start(); }

echo '<h1>Song Detail</h1>';

?>





<?php

if (!empty($_GET['artistName']) && !empty($_GET['songName'])) {
    $artist = $_GET['artistName'];
    $trackname = $_GET['songName'];
    echo '<p class="frame">';
    echo 'Artist: '.$artist.'<br>';
    echo 'Track: '.$trackname.'<br>';
    echo '</p>';

    // get song info
    $info = json_decode(SongInfo::getInfo($artist, $trackname));

    // song meaning
    echo 'Meaning: <br>';
    echo '<p class="frame">';
    
    if ($info != NULL && $info->meaning != NULL) {
        echo $info->meaning->value;
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
                $.post('SongInfo_controller.php', {'action':'submitInfo', 'artist':artist, 'trackname':trackname, 'infoType':'meaning', 'info':meaning, 'userID':userID}, function(data,status){
                    if ("success" == data) {
                        $("#meaningResult").html("Meaning Submitted!").css('color','green');
                        $("head").append('<meta http-equiv="refresh" content="2">');    
                    }
                    else {
                        $("#meaningResult").html("Submission failed: "+data).css("color","red");
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

    // song video link
    echo 'Video link: <br>';
    echo '<p class="frame">';
    
    if ($info != NULL && $info->videoLink != NULL) {
        echo $info->videoLink->value;
    }
    else {
        echo 'There is no video link for this song.';
    }

    echo '<br>';
    if ($user->loggedIn()) {
        ?>

        <a href="" data-toggle="modal" data-target="#linkSubmitModal">Submit My Video Link</a>
        

        <script>
        // Ajax Submit Meaning
        $(document).ready(function(){
            $("#linkSubmitButton").click(function(){
                var userID = <?php echo $user->getID() ?>;
                var artist = '<?php echo $artist ?>';
                var trackname = '<?php echo $trackname ?>';
                var link = $("#link").val();
                //$("#result").html("<h1>"+userID+" "+artist+" "+trackname+" "+link+"</h1>");
                $.post('SongInfo_controller.php', {'action':'submitInfo', 'artist':artist, 'trackname':trackname, 'infoType':'video_link', 'info':link, 'userID':userID}, function(data,status){
                    if ("success" == data) {
                        $("#linkResult").html("Video Link Submitted!").css('color','green');
                        $("head").append('<meta http-equiv="refresh" content="2">');    
                    }
                    else {
                        $("#linkResult").html("Submission failed: "+data).css("color","red");
                    }
                });
            });
        });
        </script>

        <!-- Bootstrap Modal Video Link Submission -->
        <div class="modal fade" id="linkSubmitModal" tabindex="-1" role="dialog" aria-labelledby="linkSubmitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="linkSubmitModalLabel">Submit My Video Link</h4>
                        <p style="color:gray">You will get notified whether your meaning is approved to be displayed for the song!</p>
                    </div>
                    <div class="modal-body">

                        <label for="link">Video Link:</label>
                        <textarea placeholder="Link" class="form-control" rows="10" id="link" name="link"></textarea>

                        <input type="submit" class="btn btn-primary" id="linkSubmitButton" value="Submit" name="submit">
                        <p id="linkResult"></p>
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

    
    // image
    echo 'Image: <br>';
    if ($info != NULL && $info->image != NULL) {
        echo '<img src="'."images/".$info->image->value.'">';
    }
    else {
        echo 'There is no image for this song.';
    }

    ?>
    <!-- upload image -->
    <form method="post" id="image_upload_form">
        <label for="image">Filename:</label>
        <input type="file" name="image" id="file"><br>
        <input type="hidden" name="action" value="submitInfo">
        <input type="hidden" name="artist" value="<?php echo $_GET['artistName'] ?>">
        <input type="hidden" name="trackname" value="<?php echo $_GET['songName'] ?>">
        <input type="hidden" name="infoType" value="image">
        <input type="hidden" name="userID" value="<?php echo $user->getID() ?>">
        <input type="submit" name="submit" value="Submit" class="submit" id="submit">
    </form>
    <p id="imageUploadResult"></p>

    <script>
    $(document).ready(function() { //shorthand document.ready function
        $('#image_upload_form').on('submit', function(e) { //use on if jQuery 1.7+
            e.preventDefault();  //prevent form from submitting

            $("#imageUploadResult").html("uploading...").css("color","red");

            var form = $(this);
            var formdata = false;
            if (window.FormData){
                formdata = new FormData(form[0]);
            }

            var formAction = form.attr('action');
            $.ajax({
                url         : 'SongInfo_controller.php',
                data        : formdata ? formdata : form.serialize(),
                cache       : false,
                contentType : false,
                processData : false,
                type        : 'POST',
                success     : function(data, textStatus, jqXHR){
                    // Callback code
                    $("#imageUploadResult").html(data).css("color","red");
                }
            });

        });
    });
    </script>

    <?php

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
                
                $.post('SongInfo_controller.php', {'action':'submitInfo', 'artist':artist, 'trackname':trackname, 'infoType':'lyrics', 'info':lyrics, 'userID':userID}, function(data,status){
                    if ("success" == data) {
                        $("#lyricsResult").html("Lyrics Submitted!").css('color','green');
                        $("head").append('<meta http-equiv="refresh" content="2">');
                    }
                    else {
                        $("#lyricsResult").html("Submission failed: "+data).css("color","red");
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