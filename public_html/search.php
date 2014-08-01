
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<script>
$(function() {

	var query = getUrlParam('search');
    if (query != null)
    {
    	query = query.replace(/\+/g," ");
    	query = query.trim();
        document.getElementById('search').value = query;
    }

	/*$("#search").autocomplete({
       	source: "autocomplete.php",
        minLength: 2,
    });*/

    $('#loadmore').click(function() {
    	alert("loadmore");
	    var page = $(this).attr('page');
	   	var category = $(this).attr('category');
	    $.ajax({
	        url:'load-data.php',
	        type:'get',
	        data:{'page':page, 'category': category , 'query':query},
	        success: function (res) {
	            var result = $.parseJSON(res);
	            //alert(page);
	            //alert(result);
	            $('#artistSearchResultsList').append(result);
	            $('#loadmore').attr('page',++page);
	        },
	        error: function(){
	        	alert("failed");
	        }
	    });
	});


});

function getUrlParam(name)
{
  var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); 
  var r = window.location.search.substr(1).match(reg); 
  if (r!=null)
    return unescape(r[2]); 
  return null; 
}


</script>

<meta charset="UTF-8">
<?php include '../www/includes/headertest.php'; ?>
<?php require_once './search-function.php'; ?>


</br>
    <div class="main-content"> 
    <div class="container-fluid">   
<?
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";

	$searchControler = new searchControler();

	$currentSearchString = $searchControler->getCurrentSearchString();

	$searchControler->printCategory($currentSearchString);
	

	$category = $_GET['category'];

	if ($category == "all")
	{	
		$searchControler -> searchArtist(5,$currentSearchString);
		
		
		$searchControler->searchAlbum(5,$currentSearchString);

		
		$searchControler->searchSongs(10,$currentSearchString);
		
	}

	if ($category == "artists")
	{
		$searchControler->searchArtist(30,$currentSearchString);
	}

	if ($category == "albums")
	{
		$searchControler->searchAlbum(30,$currentSearchString);		
	}

	if ($category == "songs")
	{
		$searchControler->searchSongs(30,$currentSearchString);
	}

?>

</div>
</div>
</body>

<? 	include '../www/includes/footertest.php'; ?>



						
