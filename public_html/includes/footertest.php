</body>
</html>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="styles/jquery.lazyload.min.js"></script> 
<script src="bootstrap/js/bootstrap.js"></script> 
<script>
		$(document).ready(function() {
			var winWidth = $(window).width();
			var winHeight = $(window).height();
			ReSizer(winWidth);
			
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
				ReSizer(nw);
			});
        }); //end doc.ready
		function sticky_relocate() {
			if($(window).scrollTop() > 20) {
				$("#mainNav").addClass("navbar-fixed-top");
				$("body").addClass("scrollBody");
			}
			else {
				$("#mainNav").removeClass("navbar-fixed-top");
				$("body").removeClass("scrollBody");
			}
			var p = $("#search").position();
			$("#searchForm #button").css("top", p.top);
			$("#hidden").css("right", p.right);
			var currRight = parseInt($("#hidden").css("right"), 10);
			$("#searchForm #button").css("right", currRight );
		}
		function ReSizer(width) {
			if(width > 768) {
				var sw = width - $("#logoPic").width() - $("#logoText").width() - $("#quickNav").width() - $("#memberNav").width() - 100;
				if(sw > 200)
					$("#searchForm").css("width", sw);
				else
					$("#searchForm").css("width", "100%");
			} //endif
			else {
				$("#searchForm").css("width", "100%");
				$("#searchForm form").css("float", "right");
				$("#searchForm form").css("clear", "both");
				$("#search").css("float", "left");
				
			}
			var p = $("#search").position();
			$("#searchForm #button").css("top", p.top);
			$("#hidden").css("right", p.right);
			var currRight = parseInt($("#hidden").css("right"), 10);
			$("#searchForm #button").css("right", currRight );
			var string = "dimensions: ";
	//		cropImg(".artistImg img");
		}
	/*	function cropImg(attribute) {
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
		}*/
	</script>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
?>