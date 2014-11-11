<?php

$data = curl_get_request("http://coursepress.lnu.se/kurser/");
$dom = new DomDocument();

	if($dom->loadHTML($data)) {

		$xpath = new DOMXPath($dom);
		$items = $xpath->query('//ul[@id = "blogs-list"]//div[@class = "item-title"]/a');

		foreach ($items as $item) {

			$course = $item->nodeValue;
			$url = $item->getAttribute("href");
			
			$eachCourse = curl_get_request($url);
			var_dump($eachCourse);
		}

	} else {

		die("Fel vid inläsning av HTML");
	}

function curl_get_request($url) {
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
    
}