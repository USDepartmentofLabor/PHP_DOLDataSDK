<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head>
	<title>Gov SDK Data</title>
	<link rel="stylesheet" href="css/main.css" type="text/css" media="print, projection, screen" />
	<link rel="stylesheet" href="css/style.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript">
	$(function() {		
		$("#tablesorter").tablesorter({sortList:[[0,0],[2,1]], widgets: ['zebra']});
		$("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
	});	
	</script>
</head>
<body>
<h2>Sample API Calls - Government Agencies</h2>
<p><em style="color: #f00000;">Note: API response time may take longer depending on the agency service response time...</em>
<br />
<br />
<?php

// Get SDK class from the class folder 
include 'class/GovAgenciesAPI.php';

$agencies = $govSDK->requestGovList();
echo $agencies;
echo "<br/>";

if (!empty($_POST)) {
	$data = "";
	$api = $govSDK->procAPI($data);
	echo $api;
}
?>
</body>
</html>
