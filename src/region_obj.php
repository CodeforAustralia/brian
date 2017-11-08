<?php

// header("Access-Control-Allow-Origin: http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com:8080");
// header("Content-Type:application/json");

require_once "db.php";
require_once "pretty_json.php";

require_once "location_obj.php";

$region_obj = '';
$debug = '';

// $region_location_arr = array();
$region_arr = array();


// Show all results
function get_all_areas() {
	try {
		$region_sql = "SELECT DISTINCT Area FROM testdb.Region;";

		foreach (returnDB()->query($region_sql) as $row) {

			$region_arr[] = array(
				'Area' => $row['Area']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}
	return $region_arr;
	// return region_output($region_arr);
}

// Show all results
function get_all_locations_in_region($id) {

	try {
		$region_sql = "SELECT * FROM testdb.Region WHERE RegionID = " . $id . ";";
		foreach (returnDB()->query($region_sql) as $row) {

			$region_arr[] = array(
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName'],
				'Area' => $row['Area'],
				'Locations' => get_locations_in_region($id)
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}
	
	return $region_arr;
}

// Show all results
function get_all_regions() {
	try {
		$region_sql = "SELECT * FROM testdb.Region;";

		foreach (returnDB()->query($region_sql) as $row) {

			$region_arr[] = array(
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}
	return $region_arr;
}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function region_output($arr) {
	$region_obj = array(
		'Regions' => $arr
	);

	// $json_client_obj = json_encode($location_obj);
	return $region_obj;
}