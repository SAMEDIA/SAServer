<!-- load jQuery if not available -->
<script>
  window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.11.0.min.js"><\/script>')
</script>

<?php
// load models
require_once "SongInfo.php";

if (!isset($_SESSION)) { session_start(); }

if ($user->loggedIn()) {
    ?>

    <a href="" data-toggle="modal" data-target="#songAddModal">Add A New Song</a>
    

    <script>
    // Ajax Submit Lyrics
    $(document).ready(function(){
        $("#songAddButton").click(function(){
            var artist = $("#artistNewSong").val();
            var trackname = $("#tracknameNewSong").val();
           
            $.post('SongInfo_controller.php', {'action':'submitMeta', 'artist':artist, 'trackname':trackname}, function(data,status){
                if ("success" == data) {
                    $("#songAddResult").html("New Song Added!").css('color','green');
                    $("head").append('<meta http-equiv="refresh" content="2">');
                }
                else if ("song_exist" == data) {
                	$("#songAddResult").html("This song already exists in our database!").css('color','red');
                }
                else {
                    $("#songAddResult").html("Submission failed!").css("color","red");
                }
            });

        });
    });
    </script>

    <!-- Bootstrap Modal New Song Adding -->
    <div class="modal fade" id="songAddModal" tabindex="-1" role="dialog" aria-labelledby="songAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="songAddModalLabel">Add A New Song</h4>
                    <p style="color:gray">You will be able to search for this new song at SongAbout.fm and find out what it is about!</p>
                </div>
                <div class="modal-body">

                    <label for="artistNewSong">Artist:</label>
                    <input type="text" placeholder="" class="form-control" rows="10" id="artistNewSong" name="artist"></input>
                    <label for="trackname">Trackname:</label>
                    <input type="text" placeholder="" class="form-control" rows="10" id="tracknameNewSong" name="trackname"></input>

                    <input type="submit" class="btn btn-primary" id="songAddButton" value="Add" name="submit">
                    <p id="songAddResult"></p>
                </div>
            </div>
        </div>
    </div>

    <?php
}
else {
    echo '<br>Sign in to add new songs!';
}

?>