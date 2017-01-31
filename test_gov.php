<?php
//include "GOVDataSDK.php";
include "GOVDataContext.php";
include "GOVDataRequest.php";

//Instantiate  GOV Data context object
//This  object stores the API information required to make requests

//APIv1
$context = new GOVDataContext('http://api.dol.gov','ADD_YOUR_API_KEY_HERE',null);

//APIv2-Quarry
//$context = new GOVDataContext('http://quarry.dol.gov','ADD_YOUR_API_KEY_HERE',null);

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
						'orderby' => 'asc',
						'columns' => '{ReportID:CoName:OrgType}',
						'table_alias' => 'TABLE_ALIAS');

}else{
// No method error.
}

//Make API call
$results = $request->callAPI($method, $arguments);
if (is_string($results)) {
	//handle error
		print_r($results);

} else {
		//handle success
		print_r($results);
}
?>

