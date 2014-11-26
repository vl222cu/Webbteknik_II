<?php
require_once('sec.php');
sec_session_start();

if(isset($_POST['logout'])) {

    unset($_SESSION['username']);
    unset($_SESSION['LoggedIn']);
    unset($_SESSION['csrfToken']);
    session_destroy();
	header('Location: index.php');
}
