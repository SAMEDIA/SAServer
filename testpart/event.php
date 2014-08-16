<?php 
//eventpage
//test recent data
$recentevent= array(
array('img'=>'http://www.tucer.net/up_files2014/2010-01/12649216703Gdz.jpg','event_name'=>'Event1','link'=>'http://www.tucer.net/up_files2014/2010-01/12649216703Gdz.jpg'),
array('img'=>'http://cdn.cnwimg.com/wp-content/uploads/2010/10/singer.jpg','event_name'=>'Event2','link'=>'http://cdn.cnwimg.com/wp-content/uploads/2010/10/singer.jpg'),
array('img'=>'http://www.tradearabia.com/source/2013/04/21/singer.jpg','event_name'=>'Event3','link'=>'http://www.tradearabia.com/source/2013/04/21/singer.jpg')
);

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>

<body>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
      	<?php foreach($recentevent as $recent){?>
        <div class="item active">
          <img src="<?php echo $recent['img'];?>" alt="<?php echo $recent['event_name'];?>">
          <div class="container">
            <div class="carousel-caption">
              <h1><?php echo $recent['event_name'];?></h1>
              <a class="btn btn-lg btn-primary" href="#" role="button">Check it NOW!</a></p>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
	<ul class="listview image fluid">
		<?php
		 foreach($recentevent as $recent){
		 ?>
		 <li href="#">
            <div class="icon">
                <img src="<?php echo $recent['img'];?>">
            </div>
            <div class="data">
                <h4><?php echo $recent['event_name'];?></h4>
                <p>
                    <?php echo $recent['event_name'];?>
                </p>
                <a href="#">Check it out!</a>


            </div>
        </li>
		<?php
		 }
		?>
        <li>
            <div class="icon">
                <img src="images/myface.jpg">
            </div>
            <div class="data">
                <h4>This is a my face</h4>
                <p>
                    Hi! My name is Sergey Pimenov and i'm author of Metro UI CSS from Kiev, Ukraine.
                </p>
                <a href="mailto:sergey@pimenov.com.ua">sergey@pimenov.com.ua</a>


            </div>
        </li>
        <li class="bg-color-red fg-color-white">
            <div class="icon">
                <img src="images/myface.jpg">
            </div>
            <div class="data">
                <h4 class="fg-color-white">This is a my face</h4>
                <p>
                    Hi! My name is Sergey Pimenov and i'm author of Metro UI CSS from Kiev, Ukraine.
                </p>

                <a href="mailto:sergey@pimenov.com.ua" class="fg-color-yellow">sergey@pimenov.com.ua</a>

            </div>
        </li>
        <li class="selected">
            <div class="icon">
                <img src="images/myface.jpg">
            </div>
            <div class="data">
                <h4>This is a my face</h4>
                <div class="static-rating small">
                    <div style="width: 100%" class="rating-value"></div>
                </div>
                <p>
                    Hi! My name is Sergey Pimenov and i'm author of Metro UI CSS from Kiev, Ukraine.
                </p>
                <a href="mailto:sergey@pimenov.com.ua">sergey@pimenov.com.ua</a>
            </div>
        </li>
    </ul>

<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>


</body>
</html>
