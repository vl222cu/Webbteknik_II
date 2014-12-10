<?php

require_once("TrafficInfoHandler.php");



$trafficInfoHandler = new TrafficInfoHandler(); 


if(isset($_GET["action"]) && $_GET["action"] == "getAll") {

	echo $trafficInfoHandler->handleCache();		
}
