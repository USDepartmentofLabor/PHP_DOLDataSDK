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
		
		if ($post['API'] == 0) {
			
			// No API Key required to pull XML data...
			$validxml = "http://<agency>/<method>";
			
				$api = simplexml_load_file("$validxml");
				
				foreach($api->children() as $child) {
					$data = "{$child->data}";
				}
			return $data;
				
		} elseif ($post['API'] == 1) {
			
			 //API Key required to pull JSONP data...
			$api = "http://<agency>?key=<your key>&get=<method>";
			
			$ch = curl_init($api);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host:<agency>"));
			$data .= curl_exec($ch);
			curl_close($ch);
			
			return $data;			
		}
	}
}

$govSDK = new GovSDK();