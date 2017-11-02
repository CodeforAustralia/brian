<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");

require_once "db.php";
require_once "pretty_json.php";

$client_obj = '';
$debug = '';

$JAID = '';
$FirstName = '';
$LastName = '';
$message_arr = array();
$phone_arr = array();
$ccs_location_arr = array();
$cw_location_arr = array();
$program_location_arr = array();


// Check if Debugging mode is needed
if(isset($_GET["debug"]) && !empty($_GET["debug"])) {
	$debug = $_GET['debug'];
}

// 
if(isset($_GET["JAID"]) && !empty($_GET["JAID"])) {
	$JAID = $_GET['JAID'];



	// Get JAID, first name, last name
	try {
		$offender_sql = "SELECT * FROM testdb.Offender WHERE JAID = " . $JAID . ";";

		foreach (returnDB()->query($offender_sql) as $row) {

			$JAID = $row['JAID'];
			$FirstName = $row['FirstName'];
			$LastName = $row['LastName'];
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}


	// Get phone numbers in ascending order of EndDate
	try {
		$phone_sql = "SELECT * FROM testdb.Phone WHERE JAID = " . $JAID . " ORDER BY EndDate ASC;";

		foreach(returnDB()->query($phone_sql) as $row) {

			$phone_arr[] = array(
				'PhoneNumber' => $row['PhoneNumber'],
				'StartDate' => $row['StartDate'],
				'EndDate' => $row['EndDate'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}


	// Get CCS locations in ascending order of EndDate
	try {
			$ccs_location_sql = "
			SELECT 
				* 
					FROM 
						testdb.Offender o
							JOIN testdb.OffenderCCSLocation c
								ON o.JAID=c.JAID
							JOIN testdb.Location l
								ON c.LocationID=l.LocationID
					WHERE 
						o.JAID = '". $JAID . "' ORDER BY EndDate ASC;";

		foreach(returnDB()->query($ccs_location_sql) as $row) {

			$ccs_location_arr[] = array(
				'StartDate' => $row['StartDate'],
				'EndDate' => $row['EndDate'],
				'SiteName' => $row['SiteName'],
				'GMapsAddress' => $row['GMapsAddress'],
				'PlaintextAddress' => $row['PlaintextAddress'],
				'PhoneNumber' => $row['PhoneNumber'],
				'EmailAddress' => $row['EmailAddress'],
				'OSMSNumber' => $row['OSMSNumber'],
			);
		}

	} catch (Exception $e) {
	    echo "<p>Database Error!</p>";
	}


	// Get Community Work in ascending order of EndDate
	// TODO: Select distinct values (ProgramID & Location ID duplicated)
	try {
			$cw_location_sql = "
				SELECT 
				    *
				FROM
			    testdb.Appointment a
			        JOIN
			    testdb.Program p ON a.ProgramID = p.ProgramID
			        JOIN
			    testdb.Location l ON p.LocationID = l.LocationID
			        JOIN
			    testdb.Region r ON r.RegionID = l.RegionID
				WHERE
					a.JAID = '". $JAID . "'
		        AND a.Type = 'CommunityWork' ORDER BY EndTime ASC;'";

		foreach(returnDB()->query($cw_location_sql) as $row) {

			$cw_location_arr[] = array(
				'ProgramName' => $row['ProgramName'],
				'StartTime' => $row['StartTime'],
				'EndTime' => $row['EndTime'],
				'ContactName' => $row['ContactName'],
				'Notes' => $row['Notes'],
				'Details' => $row['Details'],
				'SiteName' => $row['SiteName'],
				'GMapsAddress' => $row['GMapsAddress'],
				'PlaintextAddress' => $row['PlaintextAddress'],
				'PhoneNumber' => $row['PhoneNumber'],
				'EmailAddress' => $row['EmailAddress'],
				'OSMSNumber' => $row['OSMSNumber'],
				'RegionName' => $row['RegionName'],
			);
		}

	} catch (Exception $e) {
	    echo "<p>Database Error!</p>";
	}


	// Get messages in ascending order of DateDelivered
	try {
		$message_sql = "SELECT * FROM testdb.Message WHERE JAID = " . $JAID . " ORDER BY DateDelivered ASC;";

		foreach(returnDB()->query($message_sql) as $row) {

			$message_arr[] = array(
				'MessageType' => $row['MessageType'],
				'Outbound' => $row['Outbound'],
				'To' => $row['To'],
				'From' => $row['From'],
				'ResponseRequired' => $row['ResponseRequired'],
				'MessageContents' => $row['MessageContents'],
				'DeliveryStatus' => $row['DeliveryStatus'],
				'DateDelivered' => $row['DateDelivered'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}


	// Create JSON encoded object to be served with previous array data
	// (phones, ccs locations, programs, messages)
	$client_obj = array(
		'JAID' => $JAID,
		'FirstName' => $FirstName,
		'LastName' => $LastName,
		'Phones' => $phone_arr,
		'CCSLocations' => $ccs_location_arr,
		'CommunityWork' => $cw_location_arr,
		'Messages' => $message_arr
	);
	$json_client_obj = json_encode($client_obj);


	// Debugging modes
	if($debug) {
		print_r(indent($json_client_obj));
	}
	else {
		$json_client_obj = json_encode($client_obj);
		echo $json_client_obj;
	}
}
else {
	// response(400,"Invalid Request",NULL);
}