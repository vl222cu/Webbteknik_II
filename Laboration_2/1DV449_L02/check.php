<?php
require_once("sec.php");
require_once("./libraries/password_compat-master/lib/password.php");

// check tha POST parameters
$u = isset($_POST['username']) ? strip_tags(trim($_POST['username'])) : '';
$p = isset($_POST['password']) ? strip_tags(trim($_POST['password'])) : '';

if(isset($u) && isset($p)) {

	$dbPwd = getDBPwd($u);

	if(verifyUserPwd($p, $dbPwd)) {
		// set the session
		sec_session_start();
		$_SESSION['LoggedIn'] = true;
		$_SESSION['username'] = $u;
		$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['csrfToken']= setCsrfToken();

		header("Location: mess.php"); 
		exit();

	} else {
		// Too bad
		header('HTTP/1.1 401 Unauthorized');
		die("could not call");
	}
} 

// Preventing from session hijacking
if(userIsLoggedIn()) {

	if(getSessionControl() == false) {

		header('HTTP/1.1 401 Unauthorized');
		die("could not call");

	} else {

		header("Location: mess.php"); 
		exit();
	}
}
