
<html>
	<head>
		<title>Upload Event Link</title>
		<!-- date time picker css -->
		<link href="./styles/bootstrap.min.css" rel="stylesheet" media="screen">
    	<link href="./styles/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		<!--  -->

	</head>
	<body>

		  <form class="form-horizontal" action="../songabout_lib/LiveStreamController.php" method="post" name="submiteventform" enctype="multipart/form-data">
		    <fieldset>
		      <div id="legend" class="">
		        <legend class="">Add New Event</legend>
		      </div>
		    

		    <div class="control-group">
		          <label class="control-label">Event Type</label>
		          <div class="controls">
		      <!-- Inline Radios -->
		      <label class="radio inline">
		        <input type="radio" value="Concert" name="event_type" checked="checked">
		        Concert
		      </label>
		      <label class="radio inline">
		        <input type="radio" value="Festival" name="event_type">
		        Festival
		      </label>
		      <label class="radio inline">
		        <input type="radio" value="Radio" name="event_type">
		        Radio
		      </label>
		  </div>
		        </div><div class="control-group">

		          <!-- Text input-->
		          <label class="control-label" for="input01">Event Name</label>
		          <div class="controls">
		            <input type="text" placeholder="Enter event name here" class="input-xlarge" name="event_name">
		            <p class="help-block">If there's no event name, just leave it blank</p>
		          </div>
		        </div>

		    

		    <div class="control-group">

		          <!-- Text input-->
		          <label class="control-label" for="input01">Featuring Artist:</label>
		          <div class="controls">
		            <input type="text" placeholder="Enter artist here" class="input-xlarge" name="artist">
		            <p class="help-block">If it's multiple artist, just enter the first one</p>
		          </div>
		        </div>

            <div class="control-group">
                <label class="control-label">Start Time</label>
                <div class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" readonly name="start_time">
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
				<input type="hidden" id="dtp_input1" value="" /><br/>
            </div>

		    

		    <div class="control-group">

		          <!-- Select Basic -->
		          <label class="control-label">Genre</label>
		          <div class="controls">
		            <select class="input-xlarge" name="genre">
		      <option>Rock</option>
		      <option>Country</option>
		      <option>Pop</option></select>
		          </div>

		        </div>

		    

		    <div class="control-group">

		          <!-- Text input-->
		          <label class="control-label" for="input01">Stream Link</label>
		          <div class="controls">
		            <input type="text" placeholder="Add Link Here" class="input-xlarge" name="links">
		            <p class="help-block">*Required</p>
		          </div>
		        </div>

		    <div class="control-group">

		          <!-- Text input-->
		          <label class="control-label" for="input01">Place</label>
		          <div class="controls">
		            <input type="text" placeholder="Enter Event Place" class="input-xlarge" name="place">
		            <p class="help-block"></p>
		          </div>
		        </div>

		    <div class="control-group">

		          <!-- Text input-->
		          <label class="control-label" for="input01">Source Name</label>
		          <div class="controls">
		            <input type="text" placeholder="Enter Source Here" class="input-xlarge" name="source_name">
		            <p class="help-block">Name of the Link's Source</p>
		          </div>
		        </div>

		    <div class="control-group">

		          <!-- Search input-->
		          <label class="control-label">Place2</label>
		          <div class="controls">
		            <input type="text" placeholder="auto suggest" class="input-xlarge search-query" name="place2">
		            <p class="help-block">Place2</p>
		          </div>

		        </div>

		    <div class="control-group">
		          <label class="control-label"></label>

		          <!-- Button -->
		          <div class="controls">
		            <button class="btn btn-success" type="submit">Submit</button>
		          </div>
		        </div>

		    </fieldset>
		  </form>


		<script type="text/javascript" src="./scripts/datetimepicker/jquery-1.8.3.min.js" charset="UTF-8"></script>
		<script type="text/javascript" src="./scripts/datetimepicker/bootstrap.min.js"></script>
		<script type="text/javascript" src="./scripts/datetimepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<script type="text/javascript">
		    $('.form_datetime').datetimepicker({
		        //language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
		        showMeridian: 1
		    });
			$('.form_date').datetimepicker({
		        language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
		    });
			$('.form_time').datetimepicker({
		        language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 1,
				minView: 0,
				maxView: 1,
				forceParse: 0
		    });
		</script>
	</body>
</html>