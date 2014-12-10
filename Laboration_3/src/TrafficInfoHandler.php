<?php

class TrafficInfoHandler {

private $maxNumberOfMessages = 100;
private $file = 'src/file.json';

	public function handleCache(){
		
		//säkerhetskoll ifall filen skulle vara tom
		$data = file_get_contents($this->file);

		if (!empty($data)) {
			//kontroll om ny hämtning till fil ska göras
			$dataDecoded = json_decode($data);
			$scrapedTime = $dataDecoded->timestamp;
			$cacheExpire = date('Y/m/d H:i:s', strtotime('- 10 minutes'));
			if ($scrapedTime < $cacheExpire) {
				//cachen är äldre än 10 minuter - gör ny hämtning
				$this->getTrafficMessages();
			}
		//filen är tom, gör en ny hämtning	
		} else {
			
			$this->getTrafficMessages();
		}
	}

	public function getTrafficMessages(){
		//ny hämtning från SR:
		$data = $this->curlGetRequest("http://api.sr.se/api/v2/traffic/messages?format=json&pagination=false");
		//gör om till array
		$data = json_decode($data, true);
		//vänd på array så att senaste meddelandena kommer först
		$messages = $data['messages'];
		$reversed = array_reverse($messages);
		//använd bara 100 senaste
		$trimmedMessages = array();
		for ($i=0; $i < $this->maxNumberOfMessages; $i++) { 
			$this->trimmedMessages[] = $reversed[$i];
		}
		//spara relevant info i ny array, ihop med tidsstämpeln
		$json = array(
    		'timestamp' => date('Y/m/d H:i:s'),
    		'messages' => $this->trimmedMessages
			);
		//gör om till json
		$json = json_encode($json, JSON_PRETTY_PRINT);
		//lägg i fil
		file_put_contents($this->file, $json);
	}
	//curl
	public function curlGetRequest($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept' => 'application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}