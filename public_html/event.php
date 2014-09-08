<?php 

//for test use

include('EventController.php');

session_start();

$genrelist = array('rock','country','pop');

$eventlist = $_SESSION["eventlist"];

//var_dump($eventlist);

$pageTitle="SongAbout Live Stream";

include 'includes/headertest.php';

?>
<!-- Bootstrap -->

<link href="./styles/eventmain/bootstrap.min.css" rel="stylesheet">



<!-- Main Style -->

<link href="./styles/eventmain/main.css" rel="stylesheet">



<!-- Supersized -->

<link href="./styles/eventmain/supersized.css" rel="stylesheet">

<link href="./styles/eventmain/supersized.shutter.css" rel="stylesheet">



<!-- FancyBox -->

<link href="./styles/eventmain/fancybox/jquery.fancybox.css" rel="stylesheet">



<!-- Font Icons -->

<link href="./styles/eventmain/fonts.css" rel="stylesheet">



<!-- Shortcodes -->

<link href="./styles/eventmain/shortcodes.css" rel="stylesheet">



<!-- Responsive -->

<link href="./styles/eventmain/bootstrap-responsive.min.css" rel="stylesheet">

<link href="./styles/eventmain/responsive.css" rel="stylesheet">



<!-- Supersized -->

<link href="./styles/eventmain/supersized.css" rel="stylesheet">

<link href="./styles/eventmain/supersized.shutter.css" rel="stylesheet">



<!-- Google Font -->

<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>



<!-- Fav Icon -->

<link rel="shortcut icon" href="#">



<link rel="apple-touch-icon" href="#">

<link rel="apple-touch-icon" sizes="114x114" href="#">

<link rel="apple-touch-icon" sizes="72x72" href="#">

<link rel="apple-touch-icon" sizes="144x144" href="#">



<!-- Modernizr -->

<script src="./scripts/eventmain/modernizr.js"></script>



<!-- Analytics -->

<script type="text/javascript">



  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'Insert Your Code']);

  _gaq.push(['_trackPageview']);



  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();



</script>

<!-- End Analytics -->

<!-- VideoJS -->

<link href="http://vjs.zencdn.net/4.7/video-js.css" rel="stylesheet">

<script src="http://vjs.zencdn.net/4.7/video.js"></script>

<style type="text/css">

  .vjs-default-skin .vjs-control-bar { font-size: 100% }

</style>

<!-- end of VideoJS -->


<!-- This section is for Splash Screen -->

<div class="ole">

<section id="jSplash">

	<div id="circle"></div>

</section>

</div>

<!-- End of Splash Screen -->







<!-- Our Work Section -->

<div id="work" class="page">

	<div class="container">



        

        <!-- Portfolio Projects -->

        <div class="row">

        	<div class="span3">

            	<!-- Filter -->

                <nav id="options" class="work-nav">

                    <ul id="filters" class="option-set" data-option-key="filter">

                        <li><a href="#filter" data-option-value="*" class="selected">All Events</a></li>

                        <li><a href="#filter" onclick="showhidden('category')" >Category</a></li>

                        <div id="category" style="display: none;">

                            <li><a href="#filter" data-option-value=".Concert">Concert</a></li>

                            <li><a href="#filter" data-option-value=".Festival">Festival</a></li>

                        </div>

                        <li><a href="#filter" onclick="showhidden('genrelist')" >Genre</a></li>

                        <div id="genrelist" style="display: none;">

                            <?php foreach($genrelist as $genre) {?>

                            <li><a href="#filter" data-option-value=".<?php echo ucfirst($genre)?>">    <?php echo ucfirst($genre)?></a></li>

                            <?php }?>

                        </div>

                        <li><a href="#filter" data-option-value=".photography">Time</a></li>

                    </ul>

                </nav>

                <!-- End Filter -->

            </div>



            <div class="span9">

            	<div class="row">

                	<section id="projects">

                    	<ul id="thumbs">

                        

                            <?php foreach($eventlist as $event){?>

							<!-- Item Project and Filter Name -->

                                <li class="item-thumbs span3 <?php echo ucfirst($event['livestream_genre'])?> <?php echo ucfirst($event['livestream_category'])?>">

                                    <!-- Fancybox - Gallery Enabled - Title - Full Image -->



                                    <!-- Thumb Image and Description -->

                                    <img src="<?php echo $event['livestream_img']?>" alt="<?php echo $event['livestream_name']?>">

                                    <div><?php echo $event['livestream_artist_name']?></div>

                                    <div><?php echo $event['livestream_name']?></div>

                                    <div id="event<?php echo $event['livestream_id']?>time"style="display: none;"><?php echo $event['livestream_time']?></div>

                                    <div id="event<?php echo $event['livestream_id']?>countdown"> </div>

                                   <!-- countdown -->

                                   <!--  end of countdown-->

                                    <a href="addNewEvent.php?event_id=<?php echo $event['livestream_id']?>"><div >Take me to the show</div></a>

                                </li>

                        	<!-- End Item Project -->

                            <?php }?>



                            

							

                        </ul>

                    </section>

                    

            	</div>

            </div>

        </div>

        <!-- End Portfolio Projects -->

    </div>

</div>

<!-- End Our Work Section -->



<span id="countdown"></span>





<!-- Back To Top -->

<a id="back-to-top" href="#">

	<i class="font-icon-arrow-simple-up"></i>

</a>

<!-- End Back to Top -->







<?php include "includes/footertest.php"; ?>

<!-- Js -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->

<script src="./scripts/eventmain/bootstrap.min.js"></script> <!-- Bootstrap -->

<script src="./scripts/eventmain/supersized.3.2.7.min.js"></script> <!-- Slider -->

<script src="./scripts/eventmain/waypoints.js"></script> <!-- WayPoints -->

<script src="./scripts/eventmain/waypoints-sticky.js"></script> <!-- Waypoints for Header -->

<script src="./scripts/eventmain/jquery.isotope.js"></script> <!-- Isotope Filter -->

<script src="./scripts/eventmain/jquery.fancybox.pack.js"></script> <!-- Fancybox -->

<script src="./scripts/eventmain/jquery.fancybox-media.js"></script> <!-- Fancybox for Media -->

<script src="./scripts/eventmain/jquery.tweet.js"></script> <!-- Tweet -->

<script src="./scripts/eventmain/plugins.js"></script> <!-- Contains: jPreloader, jQuery Easing, jQuery ScrollTo, jQuery One Page Navi -->

<script src="./scripts/eventmain/main.js"></script> <!-- Default JS -->

<script>

function showhidden(target){

    $('#'+target).toggle();

}

</script>

<script>

//count down

function countdown(target){

    var eventtimeelement = document.getElementById("event"+target+"time");

    //$('#event'+target+'time').innerHtml;

    // set the date we're counting down to

    var eventtime = eventtimeelement.innerHTML;



    var target_date = new Date(eventtime).getTime();

     

    // variables for time units

    var days, hours, minutes, seconds;

     

    // get tag element

    var countdown = document.getElementById("event"+target+"countdown");

     

    // update the tag with id "countdown" every 1 second

    setInterval(function () {

     

        // find the amount of "seconds" between now and target

        var current_date = new Date().getTime();

        var seconds_left = (target_date - current_date) / 1000;

     

        // do some time calculations

        days = parseInt(seconds_left / 86400);

        seconds_left = seconds_left % 86400;

         

        hours = parseInt(seconds_left / 3600);

        seconds_left = seconds_left % 3600;

         

        minutes = parseInt(seconds_left / 60);

        seconds = parseInt(seconds_left % 60);

         

        // format countdown string + set tag value

        // if(seconds_left == 0){

        //     //image tag here to show a live image on the right corner

        //     countdown.innerHTML = "<a href='addNewEvent.php?event_id=<?php echo $event['livestream_id']?>'>LIVE NOW</a>";

        // }

        // else{

            countdown.innerHTML = days + "d, " + hours + "h, "

            + minutes + "m, " + seconds + "s";  

        // }

    }, 1000);

}



<?php

foreach ($eventlist as $event) {

    ?>

    countdown(<?php echo $event['livestream_id']?>);

    <?php

}

?>

</script>