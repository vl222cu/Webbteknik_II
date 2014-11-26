<?php

// get the specific message
/*function getMessages() {
	$db = null;

	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Connectionerror, try again!");
	}
	
	$q = "SELECT * FROM messages";
	
	$result;
	$stm;	
	try {
		$stm = $db->prepare($q);
		$stm->execute();
		$result = $stm->fetchAll();
	}
	catch(PDOException $e) {
		echo("Error creating query: " .$e->getMessage());
		return false;
	}
	
	if($result)
		return $result;
	else
	 	return false;
}*/

function getMessages() {

	try {

        $db = new PDO("sqlite:db.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM messages";
        $query= $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        if(!$result) {

            return false;
        }
    }

    catch(PDOEception $e) {

        die("Something went wrong, try again!");
    }

    return $result;
}

