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
			$j_son = array('Course' => $course, 'URL' => $url, 'CourseID' => '', 'Syllabus' => '', 'Course Description' => '');

			$j_sonData = json_encode($j_son);

			echo $j_sonData, "<br />";
		}

	} else {

		die("Fel vid inläsning av HTML");
	}

function curl_get_request($url) {
    
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $ch = curl_init();

    $options = array(
        CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
        CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
        CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
        CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
        CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
        CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
        CURLOPT_USERAGENT => $userAgent,// Setting the useragent
        CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
    );
    
    curl_setopt_array($ch, $options);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
    
}