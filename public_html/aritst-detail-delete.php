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



	if(isset($_GET["letter"])) {

		$currentLetterTag = $_GET["letter"];

	} else {

		$currentLetterTag = 'All';

	}

	

	require_once 'includes/staffPicksVar.php';

			

?>

<?php 	include 'includes/header.php'; ?>

    <div id="contentWrapper" class="left"> 

        <div id="songAboutContent" class="center">   

			<div id="" class="left col-1"> 

			

            </div>

			<div id="col-2" class="left col-2"> 

			

            </div>                		

            <span class="clear"></span>

		</div>

    </div>

	<span class="clear"></span>

<?php 	include 'includes/footer.php'; ?>

