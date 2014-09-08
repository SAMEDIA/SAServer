<div class="navbar-bottom navbar navbar-inverse"> 
<div class="footer-content">
<ul class="nav navbar-nav navbar-left footernav">
	<li><a href="#">LYRICS</a></li>
    <li><a href="#">ARTISTS</a></li>
    <li><a href="#">ALBUMS</a></li>
    <li><a href="#">REVIEWS</a></li>
    <li><a href="#">CONCERTS</a></li>
    <!---FOR FUTURE USE
            <li><a href="#">CONCERTS</a></li>--->
</ul>
<ul class="nav navbar-nav navbar-right footernav">
    <li><a href="about-us.php">ABOUT US</a></li>
    <li><a href="songabout-careers.php">CAREERS</a></li>
    <li><a href="mailto: info@songabout.fm">CONTACT US</a></li>
	<li><a href="privacy-policy.php">PRIVACY POLICY</a></li>
    <li><a href="conditions.php">TERMS AND CONDITIONS</a></li>
  </ul>
  <div id="footerbrand" class="nav navbar-nav navbar-left"><img src="images/logos/logoSongAboutFooter.png" width="50%"/>
<br />What's this song about? Fans, share your meanings here on SongAbout!</div>
	<div class="nav navbar-nav navbar-right" style="text-align:right; padding:10px;">
    <p>
    MILLIONS OF SONGS &amp; SONG LYRICS <br />
  		Copyright Songabout.fm 2014, All Rights Reserved
        </p>
        </div>
<div class="nav navbar-nav navbar-left" style="clear:both">
<?php
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);
        echo 'Page generated in '.$total_time.' seconds.';
        ?>
</div>
</div>
</div>
</body>
</html>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="styles/jquery.lazyload.min.js"></script> 
<script src="bootstrap/js/bootstrap.js"></script> 
<script>
		$(document).ready(function() {
			var winWidth = $(window).width();
			var winHeight = $(window).height();
			ReSizer(winWidth, winHeight);
			
			$(window).scroll(sticky_relocate);
    		sticky_relocate();
			$("img.lazy").lazyload({		
				effect: "fadeIn",
				skip_invisible: false
			});
			$("div.lazy").lazyload({		
				effect: "fadeIn",
				skip_invisible: false
			});
			$(window).resize(function() {
				var nw = $(window).width();
				var nh = $(window).height();
				ReSizer(nw, nh);
			});
        }); //end doc.ready
		function sticky_relocate() {
			var spW = ("#songPlayer").width();
			if($(window).scrollTop() > 20) {
				$("#mainNav").addClass("navbar-sticky");
				$("body").addClass("scrollBody");
			}
			else {
				$("#mainNav").removeClass("navbar-sticky");
				$("body").removeClass("scrollBody");
				if($(window).scrollTop() > 0)
					$("#mainNav").css("padding-top", 20-$(window).scrollTop());
				else
					$("#mainNav").css("padding-top", 20);
				/*$("#songPlayer").animate({
					width:spW;
				}, 400);*/
			}

			/*
			$("#songPlayer").animate({
					width:20px;
				}, 400);
			*/
			var p = $("#search").position();
			$("#searchForm #button").css("top", p.top);
			$("#hidden").css("right", p.right);
			var currRight = parseInt($("#hidden").css("right"), 10);
			$("#searchForm #button").css("right", currRight );
		}
		function ReSizer(width, height) {
			if(width > 768) {
				var sw = width - $("#logoPic").width() - $("#logoText").width() - $("#quickNav").width() - $("#memberNav").width() - 100;
				if(sw > 200) {
					$("#searchForm").css("width", sw);
					$(".features").css("margin-top", 50);
					$("#artistTop").css("margin-top", 80);
				}
				else {
					$("#searchForm").css("width", "100%");
					$(".features").css("margin-top", 120);
					$("#artistTop").css("margin-top", 120);
				}
			} //endif
			else {
				$("#searchForm").css("width", "100%");
				$(".features").css("margin-top", 100);
				$("#searchForm form").css("float", "right");
				$("#searchForm form").css("clear", "both");
				$("#search").css("float", "left");
				$("#artistTop").css("margin-top", 120);
			}
			var p = $("#search").position();
			$("#searchForm #button").css("top", p.top);
			$("#hidden").css("right", p.right);
			var currRight = parseInt($("#hidden").css("right"), 10);
			$("#searchForm #button").css("right", currRight );
			var string = "dimensions: ";
			cropImg(".artistImg img");
			$("#staticNav").css("height", 100);
			
			$(".artistTopImg").css("height", 0.7*height);
		}
		function cropImg(attribute) {
			if(attribute = ".artistImg img") {
				$(".artistImg").height($(".artistImg").width());
				$(".albumImg").height($(".albumImg").width());
			}
			$(attribute).each(function(i) {
				var name = $(this).attr("name");
				var w = $(this).width();
				if (name == "width") {
					$(this).animate({
					height: w
				}, 50, function(){
					width: "auto"
				});
				}
			});
		}
	</script>