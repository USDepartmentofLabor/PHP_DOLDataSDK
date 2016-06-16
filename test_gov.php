<?php
include "GOVDataContext.php";
include "GOVDataRequest.php";

/**
  * Use this SDK php file to test DOL data services api.
  * You have several production options to test (APIv1, APIv2-Quarry and business.usa.gov).
  * Find out which dataset are available by visiting http://developer.dol.gov/dataset/
  */
  
$context = null;

//APIv1 context example
//$context = new GOVDataContext('http://api.dol.gov','ADD_YOUR_API_KEY_HERE',null);

//APIv2-Quarry context example
//$context = new GOVDataContext('http://data.dol.gov','ADD_YOUR_API_KEY_HERE',null);


//Instantiate  new request object. Pass the context that contains all the API key info
$request = new GOVDataRequest($context);

// The method variable must be set for V1. Please visit http://developer.dol.gov/dataset/ for additional help
$method = NULL;

if($context->apiURL == 'V1'){
$arguments = NULL;
	//APIv1  you want to fetch data from
	//$method = "SummerJobs/getJobsListing";

	//Build Array arguments
	//Example to retrieve top 10 records and just get one field.

	$arguments =  Array('format' => '\'json\'',
						'query' => '\'Farm\'',
						'region' => '',
						'locality' => '',
						'skipCount' => '1');

}elseif($context->apiURL == 'V2'){

	//Quarry build array example
	// For APIv2 $method is always set to 'get' 
	$method = 'get';
	
	// In the arguments array, table_alias MUST be set. Please visit http://developer.dol.gov/dataset/ for additional help
	$arguments =  Array('format' => 'json',
						'orderby' => 'asc',
						'table_alias' => '');
}else{
// No apiURL error goes here.
}

//Make the API call
$results = $request->callAPI($method, $arguments);
if (is_string($results)) {
	//handle error
		print_r($results);
} else {
		//handle success
		print_r($results);
}
?>

