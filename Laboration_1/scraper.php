<?php

$data = curl_get_request("http://coursepress.lnu.se/kurser/");
$page = numberOfPages($data);
$dom = new DomDocument();
$courses = array();
$course = "";
$url = "";
$courseID = "";
$syllabus = "";
$courseInfo = "";
$coursePostTitle = "";
$coursePostedDate = "";
$coursePostedBy = "";
$courseCount = 0;

//Get paging
function numberOfPages($data) {
		
	$dom = new \DOMDocument(); 

//	if($dom->loadHTML($data)) {
		$dom->loadHTML($data);
		$xpath = new \DOMXPath($dom); 
		$numberOfPages = $xpath->query('//div[@id = "blog-dir-pag-top"]/a[@class ="page-numbers"]');

		foreach ($numberOfPages as $numberOfPage) {

			$pageNumberArr[] =  $numberOfPage->nodeValue; 
		}

		return max($pageNumberArr); 
			
/*	} else {

		die("Fel vid inläsning av HTML"); 
	}*/
}

// Load the cached json file
$file = 'result.json';
$jsonObj = json_decode(file_get_contents($file));

// Calculate if the cached json file isn't older than 5 minutes
@$cache_time = $jsonObj->Last_scrape;
$interval = date('Y/m/d H:i:s', strtotime('- 5 minutes'));

if (empty($file) || $cache_time < $interval) {

	for($i=1; $i<= $page; $i++) {

		$dataWithPages = curl_get_request("http://coursepress.lnu.se/kurser/?bpage=".$i);

		libxml_use_internal_errors(true);

		if($dom->loadHTML($dataWithPages)) {

			ini_set('max_execution_time', 300);
			$xpath = new DOMXPath($dom);
			$items = $xpath->query('//ul[@id = "blogs-list"]//div[@class = "item-title"]/a');

			foreach ($items as $item) {

				if (strpos($item->getAttribute("href") ,"kurs")) {

					$courseCount++;

					//Getting the name of the course
					$course = $item->nodeValue;

					//Getting link to each course
					$url = $item->getAttribute("href");

					//Get each course
					$eachCourse = curl_get_request($url);

					$subdom = new DomDocument();
					
					libxml_use_internal_errors(true);

					if ($subdom->loadHTML($eachCourse)) {

						$xpath = new DOMXPath($subdom);

						//Getting course code for each course
		  				$courseCodes = $xpath->query('//div[@id = "header-wrapper"]//ul/li[3]/a');
						
						foreach ($courseCodes as $courseCode) {

							$courseID = $courseCode->nodeValue;
						}

						//Getting syllabus for each course
						$courseSyllabi = $xpath->query('//*[@id="navigation"]//ul[@class = "menu"]//a');	
						
						foreach ($courseSyllabi as $courseSyllabus) {

							if (strpos($courseSyllabus->getAttribute("href") ,"kursinfo")) {

								$syllabus = $courseSyllabus->getAttribute("href");
							} 
							
						}

						//Description to each course
						$courseDescriptions = $xpath->query('//*[@id="content"]//*[@class="entry-content"]/p');	

						if ($courseDescriptions->length > 0) {

							$courseInfo = trim($courseDescriptions->item(0)->textContent);
						}

						//Title to the latest post
						$coursePosts = $xpath->query('//header[@class= "entry-header"]/h1[@class= "entry-title"]');

						if ($coursePosts->length > 0) {

							$coursePostTitle = $coursePosts->item(0)->textContent;
						} 

						//Date for the latest post
						$coursePostDates = $xpath->query('//header[@class= "entry-header"]/p[@class= "entry-byline"]');

						foreach ($coursePostDates as $coursePostDate) {

							preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}/', $coursePostDate->nodeValue, $match);
							$coursePostedDate = $match[0];
						}

						//Author to the latest post
						$coursePostAuthors = $xpath->query('//header[@class= "entry-header"]/p[@class= "entry-byline"]/strong');

						foreach ($coursePostAuthors as $coursePostAuthor) {

							$coursePostedBy = $coursePostAuthor->nodeValue;
						}
					
						$courseContent = array();
						$courseContent['Course'] = $course;
						$courseContent['CourseURL'] = $url;
						$courseContent['CourseID'] = $courseID;
						$courseContent['CourseSyllabus'] = $syllabus;
						$courseContent['courseDescription'] = $courseInfo;
						$courseContent['coursePostTitle'] = $coursePostTitle;
						$courseContent['coursePostedDate'] = $coursePostedDate;
						$courseContent['coursePostedBy'] = $coursePostedBy;

						//Clearing out the variables
						$course = "no information";
						$url = "no information";
						$courseID = "no information";
						$syllabus = "no information";
						$courseInfo = "no information";
						$coursePostTitle = "no information";
						$coursePostedDate = "no information";
						$coursePostedBy = "no information";

					}

				array_push($courses, $courseContent);

				$courseScrapeInfo = array();
				$courseScrapeInfo['Number_of_courses'] = $courseCount;
				$courseScrapeInfo['Last_scrape'] = date('Y/m/d H:i:s'); 

				$json = array_merge($courseScrapeInfo, $courses);

				file_put_contents('result.json', json_encode($json, JSON_PRETTY_PRINT)); 

				}
			}

		} else {

			die("Fel vid inläsning av HTML");
		} 
	}

echo "<a href='result.json'>Fil med resultat</a>";

} else {

	// Print out the cached results
    echo "<a href='result.json'>Fil med resultat</a>";
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


