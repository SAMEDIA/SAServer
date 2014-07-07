    <?
		session_start();
	?>
    <div id="footerWrapper" class="left">
		<div id="footerMenuWrapper" class="center">  
            <div id="footerCol1" class="left"><div id="footerLogo"><img src="/images/logos/logoSongAboutFooter.png" width="244" height="42"/></div><div id="footerDescription"><p> What's this song about? Fans, share your meanings here on SongAbout!</p></div><div id="footerSocialMenu"><div id="socialFooterTwitter" class="socialNav"><a href="https://twitter.com/SongAboutFm" target="_blank"></a></div><div id="socialFooterFacebook" class="socialNav"><a href="#" target="_blank"></a></div><div id="socialFooterGooglePlus" class="socialNav"><a href="#" target="_blank"></a></div><div id="socialFooterTumble" class="socialNav"><a href="http://songaboutfm.tumblr.com/"></a></div></div></div>
            <div id="footerCol2" class="left">
				<div id="footerNav"><a href="/lyrics.php">LYRICS</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/artist.php">ARTISTS</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/albums.php">ALBUMS</a><br><a href="/verified_artist.php">VERIFIED ARTIST</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/songabout-careers.php">JOBS</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/about-us.php">ABOUT US</a></div><div id="footerPolicy"><a href="/privacy-policy.php">PRIVACY POLICY</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/conditions.php">TERMS AND CONDITIONS</a></div><div id="songAboutStatBubble">MILLIONS OF SONGS & SONG LYRICS</div><div id="copyrightInfo">Copyright Songabout.fm 2014, All Rights Reserved</div></div>
            <div id="footerCol3" class="left"><div id="footerContact"><div class="contactItem" id="contactEmail"><a href="mailto: info@songabout.fm">info@songabout.fm</a></div><div class="contactItem" id=""></div><div id="contactAddress"></div></div></div></div>
	</div>
</div>
<div id="verifyPopUp"><img src="/images/noSGcover.png" width="125" height="125" style="float:left;"/><div style="float:left; height:125px; width: 229px; font-size: 14px; margin-left: 15px;">Please search for your artist page and select the claim page button.  If you already claimed your page just go to your page and begin entering the meanings of your songs.  </div>
</div>
<div id="loadVerifyConfirmationPopUp"><img src="/images/noSGcover.png" width="125" height="125" style="float:left;"/><div style="float:left; height:125px; width: 229px; font-size: 14px; margin-left: 15px;">A Request has been sent to the adminstration to verify your account.  Once your account has been verified you will receive an email confirming your ability to edit your page and songs.  </div>
</div>
</body>
</html>
<!--- All script files are the bottom of page to help with loading--->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="http://www.songabout.fm/scripts/simpSocialPop.js"></script>
<script type="text/javascript" src="http://www.songabout.fm/scripts/facebook/facebookLogin.js"></script>
<script src="http://www.songabout.fm/scripts/hooks/echonest-hook.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=487191714631608";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?
	if($pageTitle = 'Homepage') {
		/*echo '<script src="http://www.songabout.fm/scripts/staffPicks.js"></script>;*/
	} 	   
?>
<script>
$(document).ready(function() {
	$("#socialTwitter a").click(function() {
		twitterPopUp();
		return false;
	});
	$("#socialFacebook a").click(function() {
		postToFBFeed();
		return false;
	});		
	$('#verifyPopUp').dialog({
		autoOpen: false,minWidth: '550'
	});	
	$('#loadVerifyConfirmationPopUp').dialog({
		autoOpen: false,minWidth: '550'
	});				
	$('#searchSongAboutTxt').keypress(function (e) {
		  if (e.which == 13) {songAboutSearch($(this).val());}
	});	
	<? if($page == 'Homepage') { ?>
		$('#searchSongAboutTxtHome').keypress(function (e) {
			if (e.which == 13) {songAboutSearch($(this).val());}
		});
	<? } else if($page == 'song-detail') { ?>	
		$(".songPiece").each(function(e) {
		  	$(this).click(function(e) {
			  if($(this).attr('id') != "") {
				 $("#" + $(this).attr('id') + "PopUp").dialog("open"); 
			  }		  
			});
		});	
		$(".songPiecePopUp").each(function(e) {
			$(this).dialog({autoOpen: false});
		});
		
	<? } else if($page == 'verified-artist') { ?>	
		  	$('#verifyMeButton').click(function(e) {<? if(isset($_SESSION['activeUser'])) { ?>loadVerifyPopUp();<? } else {?>fbLogin();<? } ?>
				return false;
			});		
	<? } ?>	
	<? if($page == 'album-detail' || $page == 'song-detail' || $page == 'artist_detail') { ?>	
		$('#artistVideoPop').dialog({ autoOpen: false });
		$('#buttonPlayVideo').click(function(e) {
			$('#artistVideoPop').dialog("open");
			return false;
		});
	  	  $('#buttonClaimPage').click(function(e) {
				<? if(isset($_SESSION['activeUser']) && isset($artistName)) { ?>
					$.ajax({
						url: "http://www.songabout.fm/ajax/claimItAjax.php",
						dataType: "html",
						data: { artistName: '<?php echo $artistName ?>'},
						success: function( data ) {
							if(data == 'true') {
								loadVerifyConfirmationPopUp();
							} else {
								alert('There was an issue sending verification please try again later.')	
							}
						}
					});				 
				<? } else {?>
					fbLogin();
				<? } ?>		
				return false;
			});		
	<? } ?>
});
</script>
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-47099521-1', 'songabout.fm');ga('send', 'pageview');</script>