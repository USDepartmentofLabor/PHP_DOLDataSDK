<?php
include "GOVDataSDK.php";

/**
*
* Instantiate GOV Data context object.
* This object stores the API information required to make requests.
* You need to specify which DOL API context your using.
* You then need to create an argument for the request call.
* A full example for each API has been provided
**/

//APIv1
$context = new GOVDataContext('http://api.dol.gov','ADD_YOUR_API_KEY_HERE',null);

//APIv2-Quarry
//$context = new GOVDataContext('https://quarry.dol.gov','ADD_YOUR_API_KEY_HERE',null);

//Instantiate  new request object. Pass the context that contains all the API key info
$request = new GOVDataRequest($context);
$method = NULL;
$arguments = NULL;

if($context->apiURL == 'V1'){

	//APIv1 you want to fetch data from.
	$method = "DOLAgency/Agencies";

	//Build Array arguments
	//Example to skip 1 record and retrieve top 10 records and just get one field.
	$arguments =  Array('format' => '\'json\'','top' => '10','skipCount' => '1');


}elseif($context->apiURL == 'V2'){

	//Quarry build array example
	$method = 'get';

	//Build Array arguements for Quarry
	// Example, return 1 json record from 'accident'
	$arguments =  Array('format' => 'json','limit' => 1,'table_alias' => 'accident');

}else{
// No method error goes here.
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

