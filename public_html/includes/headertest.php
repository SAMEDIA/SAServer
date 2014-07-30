<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>

<?php
	//session_start();
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	// LyricFind API
	$LFDisplayAPI = 'd8a05b1cf5bd9e2a5761abf57543b013';
	$LFSearcAPIh = '55df723c07e5f02e52efd263c3a0d070'; 
	$LFMetadataAPI = 'fa00dc1d536580b258963f1dedef189b';
	$LFChartsAPI = '9b90fb74bdc84213310b43e7642b133e';
	
	require_once 'includes/staffPicksVar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title><?php echo $pageTitle ?></title>
<!-- Bootstrap core CSS -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="styles/main2.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script><!--<script async src="http://assets.bop.fm/embed.js"></script>-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="mainNav" class="navbar navbar-inverse" role="navigation">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
  <a id="logoPic" href="http://www.songabout.fm"><img class="navbar-brand" src="images/logos/SALogo.png"/></a> <a id="logoText" class="navbar-brand" style="color:#FFF; padding-left: 0;" href="http://www.songabout.fm">SONGABOUT</a>
  <ul id="quickNav" class="nav navbar-nav navbar-left navbar-collapse collapse">
    <li><a href="#">LYRICS</a></li>
    <li><a href="#">ARTISTS</a></li>
    <li><a href="#">ALBUMS</a></li>
    <li><a href="#">REVIEWS</a></li>
    <!---FOR FUTURE USE
            <li><a href="#">CONCERTS</a></li>--->
  </ul>
  <ul id="memberNav" class="nav navbar-nav navbar-right navbar-collapse collapse">
    <li><a href="#">SIGN IN</a></li>
    <li><a href="#">REGISTER</a></li>
  </ul>
	<div id="searchForm" class="navbar-right">
  <span style="display:none"><?php include 'includes/alphabetWidget.php'; ?></span>
  <form class="navbar-form" action="search-results.php?=">
    <input id="search" name="search" class="form-control" placeholder="Search for artists, albums, lyrics..." type="text">
    <button id="hidden"></button>
    <button id="button" class="btn glyphicon glyphicon-search"></button>
  </form>
  </div>
</div>