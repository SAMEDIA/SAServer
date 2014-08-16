var consumer_key = "ePT3qXXTOjw4ZoZcN7ALQ"

soundManager.url = 'http://utah.stormfrontproductions.net/~songabou/scripts/soundmanager/swf/';
soundManager.flashVersion = 9;
soundManager.useFlashBlock = false;
soundManager.useHighPerformance = true;
soundManager.wmode = 'transparent';
soundManager.useFastPolling = true;

function goNext() {
	soundManager.stopAll();
	if ( $('#songs').find(".currentPlay").parent().next().click().length == 0 ) {
		$('#songs li:first').click();
		//scrol to the start
	}	
	if(($(".currentPlay").position().left) > (-1 * $("#songs").position().left) + 15) {
		//$("#simpullPlayerNextArrow").click();
	}
}

function goPrev() {
	soundManager.stopAll();
	if ( $('#songs').find(".currentPlay").parent().prev().click().length == 0 ) {
		$('songs li:last').click();
	}
	if(($(".currentPlay").position().left) < (-1 * $("#songs").position().left) + 15) {
		//$("#simpullPlayerPrevArrow").click();
	}		
}

function pausePreviewSong() {
	soundManager.pause('songaboutPreview');			
}

function playPreviewSong(streamUrl) {
	var soundExist = soundManager.getSoundById('songaboutPreview');

	if (typeof soundExist !== 'undefined') {
		soundManager.play('songaboutPreview');	
	} else {
		soundManager.createSound({
			id: 'songaboutPreview',
			url: streamUrl,
			autoLoad: true,
			autoPlay: true,
			onplay: function() {		
				$("#playerPlayButton").hide();	
				$("#playerPauseButton").show();
			},
			onresume: function() {
				$("#playerPlayButton").hide();	
				$("#playerPauseButton").show();			
			},			
			onpause: function() {
				$("#playerPlayButton").show();	
				$("#playerPauseButton").hide();
			},		
			onfinish: function() {
				$("#playerPlayButton").show();	
				$("#playerPauseButton").hide();
			}			
		});		
	} 
}
