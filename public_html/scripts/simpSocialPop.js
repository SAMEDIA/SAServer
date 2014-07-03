function loadVerifyPopUp (){$('#verifyPopUp').dialog("open");}
function loadVerifyConfirmationPopUp (){$('#loadVerifyConfirmationPopUp').dialog("open");}
function songAboutSearch(searchTxt) {document.location.href= 'http://www.songabout.fm/search-results.php?search=' + searchTxt;}

function twitterPopUp() {
	var width  = 575,
	height = 400,
	left   = ($(window).width()  - width)  / 2,
	top    = ($(window).height() - height) / 2,
	url    = 'http://twitter.com/share',
	opts   = 'status=1' +
			 ',width='  + width  +
			 ',height=' + height +
			 ',top='    + top    +
			 ',left='   + left;
	
	window.open(url, 'twitter', opts);
	
	return false;
}

function postToFBFeed() {
	// calling the API ...
	var obj = {
	  method: 'feed',
	  link: 'https://developers.facebook.com/docs/reference/dialogs/',
	  picture: 'http://fbrell.com/f8.jpg',
	  name: 'Facebook Dialogs',
	  caption: 'Reference Documentation',
	  description: 'Using Dialogs to interact with users.'
	};
	
	function callback(response) {
	
	}
	
	FB.ui(obj, callback);
}

function linkedInPopUp() {
	var width  = 575,
	height = 400,
	left   = ($(window).width()  - width)  / 2,
	top    = ($(window).height() - height) / 2,
	url    = 'http://www.linkedin.com/shareArticle?mini=true&url=http://www.songabout.fm&title=SongAbout&summary=My%20favorite%20S&source=LinkedIn',
	opts   = 'status=1' +
			 ',width='  + width  +
			 ',height=' + height +
			 ',top='    + top    +
			 ',left='   + left;
	
	window.open(url, 'twitter', opts);
	
	return false;
}