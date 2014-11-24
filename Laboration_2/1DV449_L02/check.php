<?php
require_once("sec.php");
require_once("./libraries/password_compat-master/lib/password.php")
;
// check tha POST parameters
$u = $_POST['username'];
$p = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if user is OK
if(isset($u) && isset($p) && isUser($u, $p)) {
	// set the session
	sec_session_start();
	$_SESSION['username'] = $u;
	$_SESSION['login_string'] = $p;
	
	header("Location: mess.php"); 
}
else {
	// To bad
	header('HTTP/1.1 401 Unauthorized');
	die("could not call");
}