window.fbAsyncInit = function() {
	FB.init({
		appId      : '155802254626494', // App ID
		status     : true, // check login status
		cookie     : true, // enable cookies to allow the server to access the session
		xfbml      : true  // parse XFBML
	});

	FB.getLoginStatus(function(response) {
		
		if (response.status= 'connected') {
			FB.Event.subscribe('auth.statusChange', function(response) {
				if (response.authResponse) {
					//window.location.reload();		
				}

			});

		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			// but has not authenticated your app

		 } else {

		 }
	}, true);
	//FB.Event.subscribe('auth.statusChange', fbLoginStatus);
	FB.Event.subscribe ('auth.statusChange', function (response) {
		if(response.status == "connected"){

		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			// but has not authenticated your app
		 } else {
 
		 }
	});			
	FB.Event.subscribe('auth.login', function(response) {
		//window.location.reload();
	});

	FB.api('/me', function(response) {
	  //alert(response.name);
	});	
};  

function fbLoginStatus(response) {
 if(response.session) {
	//user is logged in, display profile div
	//alert('test1');
 } else {
	 //alert(response.status);
	//user is not logged in, display guest div
	//$("#facebookLoginDialogBox").dialog('open');
 }
}

function fbLogin(){
	FB.login(function(response) {
		if (response.authResponse) {
			access_token = response.authResponse.accessToken; //get access token
			user_id = response.authResponse.userID; //get FB UID  
	
			FB.api('/me', function(response) {
				user_email = response.email; //get user email
				// you can store this data into your database             
			});
			window.location.reload();
			//alert('test1');
	
		} else {
			console.log('User cancelled login or did not fully authorize.');
		}
	}, {
		display: 'popup',
		scope: 'email,user_birthday,offline_access'
	});
}
(function(d){
  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js";
  d.getElementsByTagName('head')[0].appendChild(js);
}(document));

