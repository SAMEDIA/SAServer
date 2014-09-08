<?php

    session_start();

    $event_id=$_SESSION['livestream_id'];

    $event_category=$_SESSION['livestream_category'];

    $event_name=$_SESSION['livestream_name'];

    $event_time=$_SESSION['livestream_time'];

    $event_artist=$_SESSION['livestream_artist_name'];

    $event_genre=$_SESSION['livestream_genre'];

    $event_link=$_SESSION['livestream_link'];

    $event_place=$_SESSION['livestream_place'];

    $event_time_zone=$_SESSION['livestream_time_zone'];

    $event_source_name=$_SESSION['livestream_source_name'];

    // $event_lon=$_SESSION['livestream_lon'];

    // $event_lat=$_SESSION['livestream_lat'];

    $eventnametag = str_replace(" ","",$event_name);

    $eventartisttag = str_replace(" ","",$event_artist);

    $eventplacetag = str_replace(" ","",$event_place);

    // $eventlon=$event_lon;

    // $eventlag=$event_lat;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        

        <title>Event Page</title>

        <link rel="stylesheet" href="./styles/jbclock.css" type="text/css" media="all" />

        <!-- for image wall -->

        <link rel="stylesheet" type="text/css" href="./styles/viewevent/demo.css" />

		<link rel="stylesheet" type="text/css" href="./styles/viewevent/style.css" />

		<script type="text/javascript" src="./scrtips/viewevent/modernizr.custom.26633.js"></script>

		<noscript>

			<link rel="stylesheet" type="text/css" href="./styles/viewevent/fallback.css" />

		</noscript>

		<style type="text/css">

			/* Container DIV - automatically generated */

			.simply-scroll-container { 

				position: relative;

			}



			/* Clip DIV - automatically generated */

			.simply-scroll-clip { 

				position: relative;

				overflow: hidden;

			}



			/* UL/OL/DIV - the element that simplyScroll is inited on

			Class name automatically added to element */

			.simply-scroll-list { 

				overflow: hidden;

				margin: 0;

				padding: 0;

				list-style: none;

			}

				

			.simply-scroll-list li {

				padding: 0;

				margin: 0;

				list-style: none;

			}

				

			.simply-scroll-list li img {

				border: none;

				display: block;

			}



			/* Custom class modifications - adds to / overrides above



			.simply-scroll is default base class */



			/* Container DIV */

			.simply-scroll { 

				width: 576px;

				height: 200px;

				margin-bottom: 1em;

			}



			/* Clip DIV */

			.simply-scroll .simply-scroll-clip {

				width: 576px;

				height: 200px;

			}

				

			/* Explicitly set height/width of each list item */	

			.simply-scroll .simply-scroll-list li {

				float: left; /* Horizontal scroll only */

				width: 290px;

				height: 200px;

			}

		</style>

    </head>

    <!-- countdown can't move to bottom -->

    <?php

        /* Set start and end dates here */

        //$startDate  = $current_time;

        $endDate = $event_time;

        /* /Set start and end dates here */

        	?>

	<script type="text/javascript">

        $(document).ready(function(){

            JBCountDown({

                secondsColor : "#FFF",

                secondsGlow  : "none",

                

                minutesColor : "#FFF",

                minutesGlow  : "none",

                

                hoursColor   : "#FFF",

                hoursGlow    : "none",

                

                daysColor    : "#FFF",

                daysGlow     : "none",



                startDate   : "<?php echo strtotime('now'); ?>",

                endDate     : "<?php echo strtotime($endDate)?>",

                now         : "<?php echo strtotime('now'); ?>"

            });

        });

    </script>    

    <script type="text/javascript" src="./scripts/countdown/jquery-1.8.0.min.js"></script>

    <script type="text/javascript" src="./scripts/countdown/jbclock.js"></script>



    

    <!-- end of countdown -->

    <body>

   

	<?php 

	if(strpos($event_link,'iframe')==true){

	?>

	<!-- for video stream -->

	<div id="video" style="display: none;">

		<div id="background" style="background-image: url(<?php echo $_SESSION['livestream_img']?>)" >

			<div id="videostream">

				<iframe width='100%' height='100%' src='<?php echo substr($event_link, 10)?>' scrolling='no' frameborder='0' style='border: 0px none transparent;'> </iframe>";

				<div></div>

			</div>

		</div>

	</div>

	<?php

	}

	else{

		?>

	<div id="video" style="">

		<div id="background" style="background-image: url(<?php echo $_SESSION['livestream_img']?>)">

			<div id="videostream"><a href="<?php echo substr($event_link, 10);?>">Take Me To The Show</a></div>

		</div>

	</div>

		<?php

	}



	if(strtotime($event_time) > strtotime('now')){

	?>

        <div class="wrapper" style="margin-top:250px;" id="countdownwrapper">



            <h1>Coming Soon!</h1>

            <h4>This <?php echo ucfirst($event_category)?> Will Be Live In:</h4>

            <div id="eventtime"><?php echo $event_time;?></div>

            <div class="clock">

                <!-- Days -->

                <div class="clock_days">

                    <div class="bgLayer">

                        <canvas id="canvas_days" width="122" height="122">

                            Your browser does not support the HTML5 canvas tag.

                        </canvas>

                        <p class="val" id="countdowndays">0</p>

                        <p class="type_days">Days</p>

                    </div>

                </div>

                <!-- Days -->

                <!-- Hours -->

                <div class="clock_hours">

                    <div class="bgLayer">

                        <canvas id="canvas_hours" width="122" height="122">

                            Your browser does not support the HTML5 canvas tag.

                        </canvas>



                        <p class="val" id="countdownhours">0</p>

                        <p class="type_hours">Hours</p>

                    </div>

                </div>

                <!-- Hours -->

                <!-- Minutes -->

                <div class="clock_minutes">

                    <div class="bgLayer">

                        <canvas id="canvas_minutes" width="122" height="122">

                            Your browser does not support the HTML5 canvas tag.

                        </canvas>

                        <div class="text">

                            <p class="val" id="countdownminutes">0</p>

                            <p class="type_minutes">Minutes</p>

                        </div>

                    </div>

                </div>

                <!-- Minutes -->

                <!-- Seconds -->

                <div class="clock_seconds">

                    <div class="bgLayer">

                        <canvas id="canvas_seconds" width="122" height="122">

                            Your browser does not support the HTML5 canvas tag.

                        </canvas>

                        <p class="val" id="countdownseconds">0</p>

                        <p class="type_seconds">Seconds</p>

                    </div>

                </div>

                <!-- Seconds -->

            </div>

        </div><!--/wrapper -->

    <?php }?>



    <!-- concert Info -->

    <!-- end of concert Info -->

    <!-- instagram -->

    <?php

   	//if($event_time>strtotime('now'))

	//define(CLIENTID, '7b3371bb57e4489ba0b40f576749b6a0');

	$CLIENTID = '7b3371bb57e4489ba0b40f576749b6a0';

	//https://api.instagram.com/v1/tags/LadyGaga/media/recent?client_id=7b3371bb57e4489ba0b40f576749b6a0

	//define(REDIRECTURL, 'http://localhost/vieweventinfo.php');



	//$location = "Red Hat Amphitheater taleigh nc";

	echo 'the tag is :'.$tag;

	//for count

	//$json = file_get_contents('https://api.instagram.com/v1/tags/'.$tag.'?access_token=1446456019.f59def8.7a74f7bbef3347079522e94e726797e1');

	// $json = file_get_contents('https://api.instagram.com/v1/tags/'.$tag.'?client_id='.$CLIENTID);



	// $decode = json_decode($json);

	//$countm = $decode->data->mediacount;

	//echo "count is:".$countm;





	//for # tags

	$eventnametagfeed = file_get_contents('https://api.instagram.com/v1/tags/'.$eventnametag.'/media/recent?client_id='.$CLIENTID);

	$eventnametagfeedres = json_decode($eventnametagfeed);

	$eventartisttagfeed = file_get_contents('https://api.instagram.com/v1/tags/'.$eventartisttag.'/media/recent?client_id='.$CLIENTID);

	$eventartisttagfeedres = json_decode($eventnametagfeed);

	$eventplacetagfeed = file_get_contents('https://api.instagram.com/v1/tags/'.$eventplacetag.'/media/recent?client_id='.$CLIENTID);

	$eventplacetagfeedres = json_decode($eventnametagfeed);

	//for location

	 	$lat = '35.759573';

	    $lng = '-79.0193';

	    echo $lat;

	    echo $lng;

	    $locationinfo= file_get_contents('https://api.instagram.com/v1/locations/search?lat='.$lat.'&lng='.$lng.'&distance=500&client_id='.$CLIENTID);

	    $locationinfores = json_decode($locationinfo);

	    $location_id = $locationinfores->data->id;

	    echo $location_id;

	    $locationfeed = file_get_contents('https://api.instagram.com/v1/locations/'.$location_id.'/media/recent?client_id='.$CLIENTID);

	    $locationfeedres = json_decode($locationfeed);



	//set img size

	$size = '200';

	?>

	<!-- Instagram Feed -->

	<!-- image wall -->



			<img class="ri-loading-image" src="./images/loading.gif"/>

			<ul id="scroller">

				<?php

				    foreach ($eventnametagfeedres->data as $pdata){

				        $date = $pdata->created_time;

				        $username = $pdata->user->username;

				        $imgurl = $pdata->images->standard_resolution->url;

				        ?>

				    	<div>

				        <?php

				            echo '<li><a href="#"><img src="'.$imgurl.'" height="'.$size.'" width="'.$size.'"  /></a></li>';

				        ?>

				    	</div>

				        <?php

				    }

				 ?>

				 <?php

				    foreach ($eventartisttagfeedres->data as $pdata){

				        $date = $pdata->created_time;

				        $username = $pdata->user->username;

				        $imgurl = $pdata->images->standard_resolution->url;

				        ?>

				    	<div>

				        <?php

				            echo '<li><a href="#"><img src="'.$imgurl.'" height="'.$size.'" width="'.$size.'" /></a></li>';

				        ?>

				    	</div>

				        <?php

				    }

				 ?>

				<?php

				    foreach ($eventplacetagfeedres->data as $pdata){

				        $date = $pdata->created_time;

				        $username = $pdata->user->username;

				        $imgurl = $pdata->images->standard_resolution->url;

				        ?>

				    	<div>

				        <?php

				            echo '<li><a href="#"><img src="'.$imgurl.'" height="'.$size.'" width="'.$size.'" /></a></li>';

				        ?>

				    	</div>

				        <?php

				    }

				 ?>

				<?php

				    foreach ($locationfeedres->data as $pdata){

				        $date = $pdata->created_time;

				        $username = $pdata->user->username;

				        $imgurl = $pdata->images->standard_resolution->url;

				        ?>

				    	<div>

				        <?php

				            echo '<li><a href="#"><img src="'.$imgurl.'" height="'.$size.'" width="'.$size.'"  /></a></li>';

				        ?>

				    	</div>

				        <?php

				    }

				 ?>

			</ul>

	<!-- end of image wall -->



	<script type="text/javascript" src="./scripts/jquery.simplyscroll.js"></script>

	<link rel="stylesheet" href="./styles/jquery.simplyscroll.css" media="all" 

	type="text/css">



	<script type="text/javascript">

	(function($) {

		$(function() { //on DOM ready 

	    		$("#scroller").simplyScroll();

		});

	 })(jQuery);





	</script>

	<script>

		function countdown(target){

		    var eventtimeelement = document.getElementById(target);

		    //$('#event'+target+'time').innerHtml;

		    // set the date we're counting down to

		    var eventtime = eventtimeelement.innerHTML;



		    var target_date = new Date(eventtime).getTime();

		     

		    // variables for time units

		    var days, hours, minutes, seconds;

		     

		    // get tag element

		    var countdown_days = document.getElementById('countdowndays');

		    var countdown_hour = document.getElementById('countdownhours');

		    var countdown_min = document.getElementById('countdownminutes');

		    var countdown_sec = document.getElementById('countdownseconds');



		     

		    // update the tag with id "countdown" every 1 second

		    var thisinterval = setInterval(function () {

		     

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

		         

		        //format countdown string + set tag value



		        if(seconds_left == 0){

		            //image tag here to show a live image on the right corner

		            //countdown.innerHTML = "<a href='addNewEvent.php?event_id=<?php echo $event['livestream_id']?>'>LIVE NOW</a>";

		            countdownsection = document.getElementById('countdownwrapper');

		            countdownsection.style.display='none';

		            video = document.getElementById('video');

		            video.style.display='inline';

		            clearInterval(thisinterval);

		        }

		        else{

		            countdown_days.innerHTML = days;

		            countdown_hour.innerHTML = hours;

		            countdown_min.innerHTML = minutes;

		            countdown_sec.innerHTML = seconds;  

		        }

		    }, 1000);

		}



		countdown('eventtime');

	</script>

    <!-- end of instagram -->

    </body>



</html>

