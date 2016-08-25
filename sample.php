<?php
include "GOVDataSDK.php";

//Instantiate  GOV Data context object
//This  object stores the API information required to make requests

//APIv1
$context = new GOVDataContext('http://api.dol.gov','ADD_YOUR_API_KEY_HERE',null);

//APIv2-Quarry
//$context = new GOVDataContext('https://quarry.dol.gov','ADD_YOUR_API_KEY_HERE',null);

//print_r($context);exit;

//Instantiate  new request object. Pass the context that contains all the API key info
$request = new GOVDataRequest($context);
$method = NULL;
if($context->apiURL == 'V1'){
$arguments = NULL;
	//APIv1  you want to fetch data from
	$method = "SummerJobs/getJobsListing";

	//Build Array arguments
	//Example to retrieve top 10 records and just get one field.


	$arguments =  Array('format' => '\'json\'',
						'query' => '\'Farm\'',
						'region' => '',
						'locality' => '',
						'skipCount' => '1');

}elseif($context->apiURL == 'V2'){

	//Quarry build array example
	$method = 'get';
	$arguments =  Array('format' => 'json',
			    'limit' => 10,
			    'table_alias' => '');

}else{
// No method error.
}

//Make API call
$results = $request->callAPI($method, $arguments);
if (is_string($results)) {
	//handle error
	echo $results;
} else {
	//handle success
	print_r($results);
}
?>

