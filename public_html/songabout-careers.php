<?php
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	require_once 'includes/staffPicksVar.php';
			
?>
<?php 	include 'includes/header.php'; ?>
	<div id="contentHeaderWrapper" class="left sg-borderless"> 
        <div id="contentHeader" class="center">  
            <div id="aboutUsBox">
                <img src="images/aboutHeaderImage.png" width="975" height="187">
            </div>
        </div>
    </div>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
            <div id="songAboutBase" class="center">
                <div id="songAboutBaseTitle" class="center">
                    Careers At Songabout
                </div>
           </div>
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<?php 	include 'includes/footer.php'; ?>
