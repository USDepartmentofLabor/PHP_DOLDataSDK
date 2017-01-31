<?php
date_default_timezone_set('UTC');

// This class handles the storage of the host, API key, and Shared Secret for your GOVDataRequest
// objects.  A GOVDataContext is valid if it has values for host, key and secret.
class GOVDataContext
{
	public $apiHost = '';
	public $apiURL = 'V1';
	public $apiKey;
	public $sharedSecret;
	public $apiUser;
	public $apiPass;

	function __construct($host, $key, $secret) {
		$this->apiHost = $host;
		$this->apiKey = $key;
		$this->sharedSecret = $secret;
		$this->updateContext();

	}

	function isValid() {
		if ($this->apiHost == "http://api.dol.gov") {
			$valid = $this->apiHost;
			return $valid;
		} elseif ($this->apiHost == "http://business.usa.gov") {
			$valid = $this->apiHost;
			return $valid;
		}elseif ($this->apiHost == "http://quarry.dol.gov"){
			$valid = $this->apiHost;
			$this->apiURL = 'V2';
			return $valid;
		}
	}

	function updateContext(){
		if ($this->apiHost == "http://quarry.dol.gov"){
			$this->apiURL = 'V2';
		}
	}

	function getApiHost(){
			return $this->apiURL;
	}
}

// This class handles requesting data from the API.  All GOVDataRequests must be initialized with a
// GOVDataContext providing a host, API key, and SharedSecet.
// The callAPI method is responsible for sending the request.
class GOVDataRequest
{
	static private $validArguments = Array(
		'top' => true,
		'skip' => true,
		'select' => true,
		'orderby' => true,
		'filter' => true
	);

	public $context;

	function __construct($context) {
		$this->context = $context;
	}

	// This method is responsible for constructing and submitting the request.
	// It returns a string if an error occured while submitting the request.
	// Otherwise, it returns an Array of instances of stdClass, each instance corresponsing to
	// a row of data from the dataset.  Each row has properties representing the datasets columns.
	function callAPI($method, $arguments = Array()) {


		if ($this->context->isValid() == "http://api.dol.gov") {
			$url = "{$this->context->apiHost}/{$this->context->apiURL}/$method?";
				$query = Array();

				foreach ($arguments as $key => $value) {
					if (array_key_exists($key, self::$validArguments)) {
						$query[] = "\$$key=" . urlencode($value);
					} else {
						$query[] = "$key=" . urlencode($value);
					}
				}
				$query = implode('&', $query);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url.$query);
				curl_setopt($ch, CURLOPT_HTTPHEADER, Array(
					"Authorization: {$this->authHeader($method, $query)}",
					"Accept: application/json"
				));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$results = curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				//print_r($url.$query);exit;

				$results = json_decode($results);
				if ($code == '200') {
					$results = $results->d;
					//uncomment (var_dump($results); exit;) to parse raw data for verification...
					//var_dump($results); exit;
					if ($results instanceof stdClass) {
						if(isset($results->results))
							$results = $results->results;
					}
				} else {
					if(isset($results->error->message->value))
						$results = $results->error->message->value;
					else
						$results = "Connection to host failed.";
				}
				return $results;
		} elseif ($this->context->isValid() == "http://business.usa.gov") {
			$url = simplexml_load_file("{$this->context->apiHost}/$method?");
			$query = Array();
			foreach ($arguments as $key => $value) {
				if (array_key_exists($key, self::$validArguments)) {
					$query[] = "\$$key=" . urlencode($value);
				} else {
					$query[] = "$key=" . urlencode($value);
				}
			}
			$query = implode('&', $query);
			// Initiate variable $i to set returned data...
			$i = 0;
			foreach($url->children() as $node) if ($i++ < 10) {
				$results[] = $node;
			}
			//uncomment (var_dump($results); exit;) to parse raw data for verification...
			//var_dump($results); exit;
			return $results;
		} elseif($this->context->getApiHost() == 'V2'){

			$get_url = '';
			if(!empty($arguments['table_alias']) && !empty($method)){
				$get_url = "{$this->context->apiHost}/{$method}/{$arguments['table_alias']}";
				unset($arguments['table_alias']);
				foreach($arguments as $filter_key => $filter_value){
					$get_url = $get_url.'/'.$filter_key.'/'.$filter_value;
				}
			}else{
				return 'ERROR: Improper input parameters.';
			}
			//print_r($get_url);exit;

			$headers = array("X-API-KEY: ".$this->context->apiKey."");
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $get_url,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_FOLLOWLOCATION => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_SSL_VERIFYHOST => FALSE,
				CURLOPT_SSL_VERIFYPEER => FALSE // set to TRUE on QA and Prod
			));

			// Execute - returns response
			//print_r($ch);

			$response = curl_exec($ch);
			curl_close($ch);
			return array($response);

		}else{
			return NULL;

		}
	}

	private function timestamp() {
		return date('Y-m-d\TH:i:s\Z');
	}

	private function authHeader($method, $query) {
		$timestamp = $this->timestamp();
		return "Timestamp=$timestamp&ApiKey={$this->context->apiKey}&Signature={$this->authSignature($timestamp, $method, $query)}";
	}

	private function authSignature($timestamp, $method, $query) {
		$dataToSign = "/{$this->context->apiURL}/$method?$query";
		$dataToSign .= "&Timestamp=$timestamp&ApiKey={$this->context->apiKey}";
		return hash_hmac('sha1', $dataToSign, $this->context->sharedSecret);
	}
}
?>
