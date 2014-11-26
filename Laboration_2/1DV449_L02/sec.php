<?php

/**
*Just som simple scripts for session handling
*/
function sec_session_start() {
        $session_name = 'vivis_kaka'; // Set a custom session name
        $secure = false; // Set to true if using https.
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params(3600, $cookieParams["path"], $cookieParams["domain"], $secure, false);
        $httponly = true; // This stops javascript being able to access the session id.
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.
}

function getDBPwd($u) {

	try {

        $db = new PDO("sqlite:db.db");
        $sql = "SELECT password FROM users WHERE username = ?";
        $query= $db->prepare($sql);
        $params = array($u);
        $query->execute($params);
        $result = $query->fetch();

        if(!$result) {

            return false;
        }
    }

    catch(PDOEception $e) {

        die("Something went wrong, try again!");
    }

    return $result['password'];
}

function verifyUserPwd($pwd, $dbPwd) {

	if(password_verify($pwd, $dbPwd)) {

        return true;
    }

    return false;
}

function userIsLoggedIn() {

	if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']) {

		return true;		
	}

	return false;
}

function getSessionControl() {

	if ($_SESSION['userAgent'] === $_SERVER["HTTP_USER_AGENT"]) {

		return true;
	}

	return false;
}

function setCsrfToken() {

	$csrfToken = md5(uniqid(rand(), true));

	return $csrfToken;
}

