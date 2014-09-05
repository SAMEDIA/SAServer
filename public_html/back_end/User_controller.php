<?php
if (!isset($_SESSION)) { session_start(); }

require_once "User.php";

if (!empty($_POST['action'])) {

	switch ($_POST['action']) {

	  case 'signIn':
	    if (!empty($_POST['email']) && !empty($_POST['password'])) {
	    	echo User::signIn($_POST['email'], $_POST['password']);
	    }
	    break;

	  case 'signUp':
	    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nickname'])) {
	    	echo User::signUp($_POST['email'], $_POST['password'], $_POST['nickname']);
	    }
	    break;

	  case 'signOut':
	    echo User::signOut();
	    break;

	  default:
	    break;
	}
	
}

?>