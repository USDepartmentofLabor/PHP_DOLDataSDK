<?php

include 'constants.inc';

class GovSDK {
	
	function requestGovList() {
		
		//Generate and assign array list. Usually this will generated using a database
		$agencyList = array("Agencies List");

		foreach ($agencyList as $k => $agency) {
			$reqform = "{$k} {$agency}";
		}		
		return $reqform;
	}
	
	//API request posted by user...
	function procAPI($data) {
		$post = $_POST;
		
		if ($post['GovAPI'] == 0) {
			
			// No API Key required to pull XML data...
			$validatexml = "http://business.usa.gov/api/article/xml";
			
				$api = simplexml_load_file("$validatexml");
				
				foreach($api->children() as $child) {
					$data = "{$child->title} {$child->learn_more_url} {$child->publish_date} {$child->detailed_text} {$child->topic}";
				}
			return $data;
				
		} elseif ($post['GovAPI'] == 1) {
			
			 //API Key required to pull JSONP data...
			$api = "http://api.census.gov/data/2010/acs5?key=<your key>&get=B25070_003E,NAME&for=county:*&in=state:06";
			
			$ch = curl_init($api);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host:api.census.gov"));
			$data .= curl_exec($ch);
			curl_close($ch);
			
			return $data;			
		}
	}
}

$govSDK = new GovSDK();