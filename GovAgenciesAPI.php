<?php

include 'include/constants.inc';

class GovSDK {
	
	function requestGovList() {
		
		//Generate and assign array list. Usually this will generated using a database
		$agencyList = array("Business USA Article",
					"Department of Commerce &rarr; API KEY REQUIRED",
					"NOAA &rarr; API KEY REQUIRED",
					"Department of Education",
					"Department of Energy",
					"Department of Health and Human Services",
					"National Center for Health Statistics",
					"National Health Information Center",
					"National Institutes of Health",
					"Department of Labor &rarr; API KEY REQUIRED",
					"Department of Transportation",
					"Federal Motor Carrier Safety Administration",
					"EPA",
					"FCC",
					"Federal Infrastructure Projects Permitting Dashboard (beta)",
					"Federal Reserve Bank of St. Louis",
					"Integrated Taxonomic Information System",
					"Millennium Challenge Corporation",
					"NASA",
					"National Archives and Records Administration",
					"National Broadband Map",
					"Office of Management and Budget",
					"Small Business Administration",
					"Small Business Innovation Research (SBIR)",
					"USA.gov",
					"White House");
		
		$reqform = "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">";
		$reqform .= "<table border=\"0\">";
		$reqform .= "<tr><td>";
		$reqform .= "<select name=\"GovAPI\">";
		foreach ($agencyList as $k => $agency) {
			if ($k == $k) {
				$reqform .= "<option value=\"{$k}\">{$agency}";
			} else {
				$reqform .= "<option value=\"{$k}\" selected=\"selected\">{$agency}";
			}
		}
		$reqform .= "</select>";
		$reqform .= "</td>";
		$reqform .= "<td><button type=\"submit\">Request Data</button></td>";
		$reqform .= "</tr></table>";
		$reqform .= "</form>";
		
		return $reqform;
	}
	
	//API request posted by user...
	function procAPI($data) {
		
		$post = $_POST;
		
		if ($post['GovAPI'] == 0) {
			
			$validatexml = "http://".BUSUSA_BASE_URL."/api/article/xml";
			
			//Validate and sanitize XML data being received...
			if (preg_match('/\A(?!XML)[a-z][\w0-9-]*/i', $validatexml)) {
				$api = simplexml_load_file("$validatexml");
				
				$data = "<h2>Business USA Article</h2>";
				$data .= "<table id=\"tablesorter\" class=\"tablesorter\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
				$data .= 	"<thead><th>Title</th><th>Learn More</th><th>Publish Date</th><th>Detailed Date</th><th>Topic</th></thead>";
				$data .= "<tbody>";
				
				foreach($api->children() as $child) {
					$data .="<tr>
						<td>{$child->title}</td>
						<td>{$child->learn_more_url}</td>
						<td>{$child->publish_date}</td>
						<td>{$child->detailed_text}</td>
						<td>{$child->topic}</td>
					</tr>";
				}			
				$data .= "</tbody>";
				$data .= "</table>";
				
				return $data;
			} else {
				$data = "No valid XML URL found or XML data does not exist...";
				return $data;
			}
		} elseif ($post['GovAPI'] == 1) {
			$post = $_POST;
			
			$data = "<h2>Department of Commerce</h2>";
			
			$api = "http://".CENSUS_BASE_URL."/data/2010/acs5?key=".CENSUS_BUREAU_KEY."&get=B25070_003E,NAME&for=county:*&in=state:06";
			$ch = curl_init($api);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: ".CENSUS_BASE_URL.""));
			$data .= curl_exec($ch);
			curl_close($ch);
			
			return $data;			
		} elseif ($post['GovAPI'] == 2) {
			$post = $_POST;
						
			$validatexml = "http://".NOAA_BASE_URL."/cdo-services/services/datasets?token=".NOAA_KEY."";
			
			//Validate and sanitize XML data being received...
			if (preg_match('/\A(?!XML)[a-z][\w0-9-]*/i', $validatexml)) {
				$api = simplexml_load_file("$validatexml");
				
				$data = "<h2>NOAA Climate Data Online</h2>";
				$data .= "<table id=\"tablesorter\" class=\"tablesorter\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
				$data .= 	"<thead><th>ID</th><th>Name</th><th>Description</th><th>Min Date</th><th>Max Date</th></thead>";
				$data .= "<tbody>";				
			
				$data .= var_dump($api);
			
				$data .= "</tbody>";
				$data .= "</table>";
		
				return $data;
			} else {
				$data = "No valid XML URL found or XML data does not exist...";
				return $data;
			}			
		}
	}
}

$govSDK = new GovSDK();