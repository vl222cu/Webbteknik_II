<?php

$data = curl_get_request("http://coursepress.lnu.se/kurser/");
$dom = new DomDocument();
$course = "";
$url = "";
$courseID = "";
$syllabus = "";
$courseInfo = "";
$coursePostTitle = "";
$coursePostedDate = "";
$coursePostedBy = "";

	if($dom->loadHTML($data)) {

		$xpath = new DOMXPath($dom);
		$items = $xpath->query('//ul[@id = "blogs-list"]//div[@class = "item-title"]/a');
		
		function isCourse ($href) {
		 	return preg_match('/kurs/', $href, $course);
		}

		foreach ($items as $item) {
			var_dump(isCourse($item->getAttribute("href")));

			if (strpos($item->getAttribute("href") ,"kurs")) {

				$course = $item->nodeValue;
				$url = $item->getAttribute("href");
				$eachCourse = curl_get_request($url);
				$subdom = new DomDocument();
				
				libxml_use_internal_errors(true);

				if ($subdom->loadHTML($eachCourse)) {

					$xpath = new DOMXPath($subdom);
	  				$courseCodes = $xpath->query('//div[@id = "header-wrapper"]//ul/li[3]/a');
					
					foreach ($courseCodes as $courseCode) {

						$courseID = $courseCode->nodeValue;
					}

					$courseSyllabi = $xpath->query('//*[@id="navigation"]//ul[@class = "menu"]//a');	
					
					foreach ($courseSyllabi as $courseSyllabus) {

						if (strpos($courseSyllabus->getAttribute("href") ,"coursesyllabus")) {

							$syllabus = $courseSyllabus->getAttribute("href"); 
						}
					}

					$courseDescriptions = $xpath->query('//*[@id="content"]//*[@class="entry-content"]');	

					($courseDescriptions->length > 0) ? $courseInfo = trim($courseDescriptions->item(0)->textContent) : 'no information';	

					$coursePosts = $xpath->query('//header[@class= "entry-header"]/h1[@class= "entry-title"]');

					($coursePosts->length > 0) ? $coursePostTitle = $coursePosts->item(0)->textContent : 'no information';

					$coursePostInfo = $xpath->query('//header[@class= "entry-header"]/p[@class= "entry-byline"]');

					if($coursePostInfo->length > 0){

						$entry = $coursePostInfo->item(0);
						$date = trim($entry->firstChild->textContent);
						preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}/', $date, $match);
						$coursePostedDate = $match[0];
						$coursePostedBy = $entry->firstChild->nextSibling->textContent;
					}
				}
			}

			libxml_use_internal_errors(false);

			$courseContent = array();
			$courseContent['Course'] = $course;
			$courseContent['CourseURL'] = $url;
			$courseContent['CourseID'] = $courseID;
			$courseContent['CourseSyllabus'] = $syllabus;
			$courseContent['courseDescription'] = $courseInfo;
			$courseContent['coursePostTitle'] = $coursePostTitle;
			$courseContent['coursePostedDate'] = $coursePostedDate;
			$courseContent['coursePostedBy'] = $coursePostedBy;
			
			$jsonData = json_encode($courseContent, JSON_PRETTY_PRINT);

			echo $jsonData, "<br />" . "<br />";
		}

	} else {

		die("Fel vid inläsning av HTML");
	}

function curl_get_request($url) {
    
    $userAgent = "vl222cu";
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