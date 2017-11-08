<?php

// header("Access-Control-Allow-Origin: http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com:8080");
// header("Content-Type:application/json");

require_once "db.php";
require_once "pretty_json.php";

$location_obj = '';
$debug = '';

$region_location_arr = array();
$location_arr = array();


// Limit locations by region, WITH details
function get_locations_in_region_detail($region_id) {
	try {
		$location_sql = "SELECT * FROM testdb.Location WHERE regionID = " . $region_id . ";";

		foreach (returnDB()->query($location_sql) as $row) {

			$location_arr[] = array(
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
	return $location_arr;
}

// Limit locations by region, NO details
function get_locations_in_region($region_id) {

	try {
		$location_sql = "SELECT * FROM testdb.Location WHERE RegionID = " . $region_id . ";";

		foreach (returnDB()->query($location_sql) as $row) {

			$location_arr[] = array(
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	return $location_arr;
}

// Get details about a specific location
function get_location_detail($location_id) {
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

	return $location_arr;
}


// Get details about all location
function get_all_locations_detail() {

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

	return $location_arr;
}


// Show all results
function get_all_locations() {
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
	return $location_arr;
}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function location_output($arr) {
	$location_obj = array(
		'Locations' => $arr
	);

	return $location_obj;
}