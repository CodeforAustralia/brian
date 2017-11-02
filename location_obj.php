<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");

require_once "db.php";
require_once "pretty_json.php";

$location_obj = '';
$debug = '';

$region_location_arr = array();
$location_arr = array();


// Check if Debugging mode is needed
if(isset($_GET["debug"]) && !empty($_GET["debug"])) {
	$debug = $_GET['debug'];
}

// If Region is set, limit locations by region, show ALL location details
if((isset($_GET["region"]) && !empty($_GET["region"])) && (isset($_GET["detail"]) && !empty($_GET["detail"]))) {
	$region_id = $_GET['region'];

	try {
		$location_sql = "SELECT * FROM testdb.Location WHERE regionID = " . $region_id . ";";

		foreach (returnDB()->query($location_sql) as $row) {

			$region_location_arr[] = array(
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
				'GMapsAddress' => $row['GMapsAddress'],
				'PlaintextAddress' => $row['PlaintextAddress'],
				'PhoneNumber' => $row['PhoneNumber'],
				'EmailAddress' => $row['EmailAddress'],
				'OSMSNumber' => $row['OSMSNumber'],
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

}
// If Region is set, limit locations by region, ONLY show region name and ID
else if(isset($_GET["region"]) && !empty($_GET["region"])) {
	$region_id = $_GET['region'];

	try {
		$location_sql = "SELECT * FROM testdb.Location WHERE regionID = " . $region_id . ";";

		foreach (returnDB()->query($location_sql) as $row) {

			$region_location_arr[] = array(
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

}
// If location is set, get details about that specific location
else if(isset($_GET["location"]) && !empty($_GET["location"])) {
	$location_id = $_GET['location'];

	try {
		$location_sql = "SELECT * FROM testdb.Location WHERE locationID = " . $location_id . ";";

		foreach (returnDB()->query($location_sql) as $row) {

			$location_arr[] = array(
				'SiteName' => $row['SiteName'],
				'GMapsAddress' => $row['GMapsAddress'],
				'PlaintextAddress' => $row['PlaintextAddress'],
				'PhoneNumber' => $row['PhoneNumber'],
				'EmailAddress' => $row['EmailAddress'],
				'OSMSNumber' => $row['OSMSNumber'],
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

}
// If location is set, get details about that specific location
else if(isset($_GET["detail"]) && !empty($_GET["detail"])) {

	try {
		$location_sql = "SELECT * FROM testdb.Location;";

		foreach (returnDB()->query($location_sql) as $row) {

			$location_arr[] = array(
				'SiteName' => $row['SiteName'],
				'GMapsAddress' => $row['GMapsAddress'],
				'PlaintextAddress' => $row['PlaintextAddress'],
				'PhoneNumber' => $row['PhoneNumber'],
				'EmailAddress' => $row['EmailAddress'],
				'OSMSNumber' => $row['OSMSNumber'],
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

}
// Otherwise just show all results
else {
	try {
		$location_sql = "SELECT * FROM testdb.Location;";

		foreach (returnDB()->query($location_sql) as $row) {

			$location_arr[] = array(
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}
}


if(!empty($region_location_arr)) {
	$location_obj = array(
		'Locations' => $region_location_arr
	);
}
else {
	$location_obj = array(
		'Locations' => $location_arr
	);
}

//TODO: Sam you stopped here

// Create JSON encoded object to be served with previous array data
// (phones, ccs locations, programs, messages)

$json_client_obj = json_encode($location_obj);

// Debugging modes
if($debug) {
	print_r(indent($json_client_obj));
}
else {
	$json_client_obj = json_encode($location_obj);
	echo $json_client_obj;
}