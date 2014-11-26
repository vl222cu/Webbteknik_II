<?php
require_once("get.php");
require_once("post.php");
require_once("sec.php");
sec_session_start();

/*
* It's here all the ajax calls goes
*/
if(isset($_GET['function'])) {

	if($_GET['function'] == 'add') {
	    $name = strip_tags(trim($_GET["name"]));
		$message = strip_tags(trim($_GET["message"]));
		$token = $GET["token"];
		$csrfToken = $_SESSION["csrfToken"];

		if($token === $csrfToken) {

			addToDB($message, $name);
			header("Location: test/debug.php");

		} else {

			session_write_close();
			die("Post message error");
		}

    }
    elseif($_GET['function'] == 'getMessages') {
  	   	echo(json_encode(getMessages()));
    }
}