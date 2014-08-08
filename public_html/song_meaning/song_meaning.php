<div id="song_meaning">

<?php

include "../user_panel/connect_database.php";
if (!isset($_SESSION)) { session_start(); }


if(isset($_GET["songID"])) {
    $songID = $_GET["songID"];
    // show song meanings
    // search for meaning in our database
    $meaningQueryResult = mysql_query("SELECT * FROM song_meaning WHERE SongID = '".$songID."'");
    // if we have meaning in database for this song
    if(mysql_num_rows($meaningQueryResult) == 1)
    {
        $row = mysql_fetch_array($meaningQueryResult);
        $meaning = $row['Meaning'];
        
        echo '<h3>Here is the meaning:</h3><p>'.$meaning.'</p></div>';

    }
    else // there is no meaning for now
    {
        echo '<h3>There is no meaning right now.</h3>';
        
    }
    // let logged in user submit new meaning
    if (!empty($_SESSION['loggedIn'])) {
        echo '<a href="" data-toggle="modal" data-target="#meaningSubmitModal">Submit My Meaning</a>';
        ?>

        <script>
        // Ajax Submit Meaning
        $(document).ready(function(){
            $("#meaningSubmitButton").click(function(){
                var userID = <?php echo $_SESSION['userID'] ?>;
                var songID = <?php echo $_GET['songID'] ?>;
                var meaning = $("#meaning").val();
                //$("#result").html("<h1>"+userID+" "+songID+" "+meaning+"</h1>");
                $.post('../song_meaning/submit_meaning.php', {'songID':songID, 'meaning':meaning, 'userID':userID}, function(data,status){
                    if ("success" == data) {
                        $("#result").html("Meaning Submitted!");
                        $("head").append('<meta http-equiv="refresh" content="2">');    
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
                        <p id="result"></p>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    
} 

?>


