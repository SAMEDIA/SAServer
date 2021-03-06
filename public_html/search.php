
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script language="javascript" type="text/javascript" src="jquery.equalheights.js"></script>

<script>
$(function() {

	var query = getUrlParam('search');
    if (query != null)
    {
    	document.getElementById('search').value = query;
    	query = query.replace(/\s+/g,"+");
    	query = query.trim();
   
    }

	/*$("#search").autocomplete({
       	source: "autocomplete.php",
        minLength: 2,
    });*/

    $('#loadmore').click(function() {
    	alert("load more");
    
	    var page = $(this).attr('page');
	   	var category = $(this).attr('category');
		alert(query +" " +category);
	   	var $btn = $(this);
    	$btn.button('loading');

	    $.ajax({
	        url:'load-data.php',
	        type:'get',
	        data:{'page':page, 'category': category , 'query':query},
	        success: function (res) {
	            var result = $.parseJSON(res);
	            //alert(page);
	            alert("success");
	            alert(result);

	            if (category == "songs")
	            	$('#ArtistSearchResults').find('tbody').append(result);
	            else
	            	$('#AlbumSearchResults').append(result);

	            $('#loadmore').attr('page',++page);
	            $btn.button('reset');
	        },
	        error: function(){
	        	alert("failed");
	        }
	    });
	});

	
    //equalHeight($(".thumbnail")); 
    equalHeight($(".albumItem")); 
    

	/*$("button").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    // simulating a timeout
    setTimeout(function () {
        $btn.button('reset');
    }, 1000);*/

});

function equalHeight(group) {    
	    /*tallest = 0;    
	    group.each(function() {       
	        thisHeight = $(this).height();       
	        if(thisHeight > tallest) {          
	            tallest = thisHeight;       
	        }    
	    }); 
	    alert(tallest);  */ 
	    group.each(function() { $(this).height(240); });
	} 

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
    
<?
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";

	$searchControler = new searchControler();

	$currentSearchString = $searchControler->getCurrentSearchString();

	$category = $_GET['category'];


	$searchControler->printCategory($currentSearchString, $category);

	if ($category == "all")
	{	
		$searchControler -> searchArtist(6,$currentSearchString);
		
		
		$searchControler->searchAlbum(6,$currentSearchString);

		
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



						
