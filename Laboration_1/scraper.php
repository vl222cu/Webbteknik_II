<?php

$data = curl_get_request("http://coursepress.lnu.se/kurser/");
$page = numberOfPages($data);
$dom = new DomDocument();
$course = "";
$url = "";
$courseID = "";
$syllabus = "";
$courseInfo = "";
$coursePostTitle = "";
$coursePostedDate = "";
$coursePostedBy = "";
$courseCount = 0;

// Load the Cached json file
/*$obj = json_decode(file_get_contents('result.json'));
var_dump($obj);
// Calculate if the cahced json file isn't older than 5 minutes
$current_time = new DateTime('now');
@$cache_time = date($obj['Last_scrape']);
$interval = $current_time->diff($cache_time, true); */

//if ($interval->i > 5) {
	for($i=1; $i<= $page; $i++) {

		$dataWithPages = curl_get_request("http://coursepress.lnu.se/kurser/?bpage=".$i);

		if($dom->loadHTML($dataWithPages)) {

			ini_set('max_execution_time', 300);
			$xpath = new DOMXPath($dom);
			$items = $xpath->query('//ul[@id = "blogs-list"]//div[@class = "item-title"]/a');

			foreach ($items as $item) {

				if (strpos($item->getAttribute("href") ,"kurs")) {

					$courseCount++;
					//Kursnamn
					$course = $item->nodeValue;

					//Kurslänk
					$url = $item->getAttribute("href");

					//Hämtning av varje kurs
					$eachCourse = curl_get_request($url);
					$subdom = new DomDocument();
					
					libxml_use_internal_errors(true);

					if ($subdom->loadHTML($eachCourse)) {

						$xpath = new DOMXPath($subdom);

						//Kurskod
		  				$courseCodes = $xpath->query('//div[@id = "header-wrapper"]//ul/li[3]/a');
						
						foreach ($courseCodes as $courseCode) {

							$courseID = $courseCode->nodeValue;
						}

						//Kursplan
						$courseSyllabi = $xpath->query('//*[@id="navigation"]//ul[@class = "menu"]//a');	
						
						foreach ($courseSyllabi as $courseSyllabus) {

							if (strpos($courseSyllabus->getAttribute("href") ,"coursesyllabus")) {

								$syllabus = $courseSyllabus->getAttribute("href");
							} 
							
						}

						//Kursens inledande text
						$courseDescriptions = $xpath->query('//*[@id="content"]//*[@class="entry-content"]/p');	

						if ($courseDescriptions->length > 0) {

							$courseInfo = trim($courseDescriptions->item(0)->textContent);
						}

						//Rubrik till senaste inlägg
						$coursePosts = $xpath->query('//header[@class= "entry-header"]/h1[@class= "entry-title"]');

						if ($coursePosts->length > 0) {

							$coursePostTitle = $coursePosts->item(0)->textContent;
						} 

						//Datum och tid till senaste inlägg
						$coursePostDates = $xpath->query('//header[@class= "entry-header"]/p[@class= "entry-byline"]');

						foreach ($coursePostDates as $coursePostDate) {

							preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}/', $coursePostDate->nodeValue, $match);
							$coursePostedDate = $match[0];
						}

						//Författare till senaste inlägget
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

					$courseScrapeInfo = array();
					$courseScrapeInfo['Number_of_courses'] = $courseCount;
					$courseScrapeInfo['Last_scrape'] = date("y/m/d h:i :s A",time()); 

					$json = array_merge($courseScrapeInfo, $courseContent);

				libxml_use_internal_errors(false);

				// Store the fresh data into the cached file
    			file_put_contents('result.json', json_encode($json, JSON_PRETTY_PRINT), FILE_APPEND);

				$jsonData = json_encode($json, JSON_PRETTY_PRINT);

				echo $jsonData . "</br>" . "</br>";

					}
				}
			}

		} else {

			die("Fel vid inläsning av HTML");
		}
	}

/*} else {

	// Print out the cached results
    echo file_get_contents('result.json');
} */

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

function numberOfPages($data) {
		
		$dom = new \DOMDocument(); 
	 
		if($dom->loadHTML($data)) {

			$xpath = new \DOMXPath($dom); 
			$numberOfPages = $xpath->query('//div[@id = "blog-dir-pag-top"]/a[@class ="page-numbers"]');

			foreach ($numberOfPages as $numberOfPage) {

				$pageNumberArr[] =  $numberOfPage->nodeValue; 
			}

			return max($pageNumberArr); 
			
		} else {

			die("Fel vid inläsning av HTML"); 
		}
	}
