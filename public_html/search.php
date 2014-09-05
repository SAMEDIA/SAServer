<?php include '../www/includes/headertest.php'; ?>
 <style>
    .ui-autocomplete-category {
        color: gray;
        border-bottom: none;
        clear: both;
        border-top: 1px solid grey;
        text-align:right;
    }

    .artist-info
    {
    	font-size: 13px;
    	height: 25px;
    }

    .album-info
    {
    	font-size: 13px;
    }
    </style>

<script>
$(function() {
	var query = getUrlParam('search');
    if (query != null)
    {
    	query = query.replace(/\+/g," ");
    	query = query.trim();
    	document.getElementById('search').value = query;
    }

    var $searchBox = $("#search");

    var widgetInst = $searchBox.autocomplete({}).data('ui-autocomplete');

    widgetInst._renderMenu = function(ul, items) {
	  var self = this;
	  var currentCategory = "";
	  
	  $.each( items, function( index, item ) {
	    if ( item.category != currentCategory ) {
				ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
				currentCategory = item.category;
			}
			self._renderItem( ul, item );
	  });
	};

	widgetInst._renderItem = function( ul, item ) {
    	
		var searchMask = this.element.val().trim();
		//split the key words with space
		var keywords = searchMask.split(" ");
		
        var regEx = new RegExp(searchMask, "ig");
        var replaceMask = "<font color='#68C07B'>$&</font>";
        var result = item.label.replace(regEx, replaceMask);

        if (result == item.label)
      		{
      			for (var i = 0; i < keywords.length; i++) {
					if (keywords[i].length > 1) {	
			        	var regEx = new RegExp(keywords[i], "ig");
			        	var replaceMask = "<font color='#68C07B'>$&</font>";
			        	result = result.replace(regEx, replaceMask);
			    	}
				};
      		}
      	if(item.artist == null)
      	{
      		
      		return $( "<li></li>" )
		    .data( "ui-autocomplete-item", item )
		    .append($("<a class='artist-info'></a>").html(result))
		    .appendTo( ul );
      	}else
      	{
      		regEx = new RegExp(searchMask, "ig");
	      	var artist = item.artist.replace(regEx, replaceMask);
	      	if (artist == item.artist)
      		{
      			for (var i = 0; i < keywords.length; i++) {
					if (keywords[i].length > 1) {	
			        	var regEx = new RegExp(keywords[i], "ig");
			        	var replaceMask = "<font color='#68C07B'>$&</font>";
			        	artist = artist.replace(regEx, replaceMask);
			    	}
				};
      		}

	      	result = result + " - " + artist;
		  	return $( "<li></li>" )
		    .data( "ui-autocomplete-item", item )
		    .append($("<a class='album-info'></a>").html(result))
		    .appendTo( ul );
		}
    	
	};

	$searchBox.autocomplete({
       	source: "autocomplete.php",
        minLength: 2,
        select: function( event, ui ) {
	        
        },
        focus: function( event, ui ) {
        	var selectedObj = ui.item;
			return selectedObj.label;
        }
	   
    });/*.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    	
		var searchMask = this.element.val().trim();
        var regEx = new RegExp(searchMask, "ig");
        var replaceMask = "<mark>$&</mark>";
        var result = item.label.replace(regEx, replaceMask);
      	//if index is -1, then it means that it is the artist result
      	if(item.artist == null)
      	{
      		return $( "<li></li>" )
		    .data( "item.autocomplete", item )
		    .append($("<a class='ui-menu-item'></a>").html(result))
		    .appendTo( ul );
      	}else
      	{
	      	var artist = item.artist.replace(regEx, replaceMask);
		  	return $( "<li></li>" )
		    .data( "item.autocomplete", item )
		    .append($("<a class='ui-menu-item'></a>").html(result))
		    .append("<a class='artist-info'>" + "  by " + artist + "</a>")
		    .appendTo( ul );
		}
    	
	};*/

    $('#loadmore').click(function() {
    	//alert("load more");
    
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
	        	console.log(res);
	            var result = $.parseJSON(res);
	            //alert(page);
	           // alert("success");
	            alert(result);
		        if (result != "")
		        {
		            if (category == "songs")
		            	$('#ArtistSearchResults').find('tbody').append(result);
		            else
		            	$('#AlbumSearchResults').append(result);

		            $('#loadmore').attr('page',++page);
		            $btn.button('reset');
		        }
		        else
		        {
		        	alert('No More Results');
		        	//$btn.attr('data-loading-text') = 'No More Results';
		        	//$btn.parentNode.remove($btn);
		        	$btn.button('reset');
		        }
	        },
	        error: function(){
	        	alert("failed");
	        }
	    });
	});

	
    //equalHeight($(".thumbnail")); 
    equalHeight($(".albumItem")); 

    window.onscroll = function (e) {  
 		$searchBox.autocomplete("close");
	} 
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

<?php require_once './search-function.php'; ?>


</br>
    <div class="main-content"> 
    
<?
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";

	$searchControler = new searchControler();

	$currentSearchString = $searchControler->getCurrentSearchString();

	$category = $_GET['category'];

	$query = $_GET['search'];

	$searchControler->printCategory($query, $category);

	if ($category == "all")
	{	
		$searchControler -> searchArtist(6,$currentSearchString,$query);
		
		
		$searchControler->searchAlbum(6,$currentSearchString,$query);

		
		$searchControler->searchSongs(10,$currentSearchString,$query);
		
	}

	if ($category == "artists")
	{
		$searchControler->searchArtist(30,$currentSearchString,$query);
	}

	if ($category == "albums")
	{
		$searchControler->searchAlbum(30,$currentSearchString,$query);		
	}

	if ($category == "songs")
	{
		$searchControler->searchSongs(30,$currentSearchString,$query);
	}

?>


</div>
</div>
</body>

<? 	include '../www/includes/footertest.php'; ?>



						
