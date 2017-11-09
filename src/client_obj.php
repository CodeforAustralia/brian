<?php
require_once "db.php";
require_once "pretty_json.php";


// Get phone numbers in ascending order of EndDate
function get_client_phone($JAID) {

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

	return $phone_arr;
}


// Get list of CMs for offender
function get_client_manager($JAID) {

	try {
		$manager_sql = "
			SELECT 
				* 
					FROM 
						testdb.OffenderAssignedToStaff s
							JOIN testdb.Staff o
								ON o.email=s.email
					WHERE 
						s.JAID = '". $JAID . "' ORDER BY EndDate ASC;";

		foreach(returnDB()->query($manager_sql) as $row) {
			// // Use this for CM object
			// $manager_arr[] = array(
			// 	'JAID' => $row['JAID'],
			// 	'email' => $row['email'],
			// 	'FirstName' => $row['FirstName'],
			// 	'LastName' => $row['LastName'],
			// 	'StartDate' => $row['StartDate'],
			// 	'EndDate' => $row['EndDate']
			// );
			$manager_arr[] = array(
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'email' => $row['email'],
				'StartDate' => $row['StartDate'],
				'EndDate' => $row['EndDate']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $manager_arr;
}

// Get CCS locations in ascending order of EndDate
function get_client_ccs_locations($JAID) {

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

	return $ccs_location_arr;
}

function get_client_community_work($JAID) {

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

	return $cw_location_arr;
}


// Get messages in ascending order of DateDelivered
function get_client_messages($JAID) {

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

	return $message_arr;
}


function get_client_detail($JAID) {
	$client_obj = '';

	$FirstName = '';
	$LastName = '';

	// Get JAID, first name, last name
	try {
		$offender_sql = "SELECT * FROM testdb.Offender WHERE JAID = " . $JAID . ";";

		foreach (returnDB()->query($offender_sql) as $row) {

			$FirstName = $row['FirstName'];
			$LastName = $row['LastName'];
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}


	// Create JSON encoded object to be served with previous array data
	// (phones, ccs locations, programs, messages)
	$client_obj = array(
		'JAID' => $JAID,
		'FirstName' => $FirstName,
		'LastName' => $LastName,
		'Phones' => get_client_phone($JAID),
		'Staff' => get_client_manager($JAID),
		'CCSLocations' => get_client_ccs_locations($JAID),
		'CommunityWork' => get_client_community_work($JAID),
		'Messages' => get_client_messages($JAID)
	);

	return $client_obj;
}

function get_client_list() {

	try {
		$offender_sql = "SELECT * FROM testdb.Offender;";

		foreach (returnDB()->query($offender_sql) as $row) {

			$offender_arr[] = array(
				'JAID' => $row['JAID'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'OptedIn' => $row['OptedIn'],
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	return $offender_arr;
}


function get_client_list_in_location($id) {

	try {
		$offender_sql = "SELECT 
    *
FROM
    testdb.Offender o
        JOIN
    testdb.OffenderCCSLocation c
    JOIN
    testdb.Location l
WHERE
    o.JAID = c.JAID AND EndDate IS NULL AND c.LocationID = l.LocationID
        AND c.LocationID = '" . $id ."';";

		foreach (returnDB()->query($offender_sql) as $row) {

			$offender_arr[] = array(
				'JAID' => $row['JAID'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'OptedIn' => $row['OptedIn'],
				'SiteName' => $row['SiteName'],
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	return $offender_arr;
}

function get_client_list_in_region($id) {

	try {
		$offender_sql = "SELECT 
    *
FROM
    testdb.Offender o
        JOIN
    testdb.OffenderCCSLocation c
    JOIN
    testdb.Location l
    JOIN
    testdb.Region r
WHERE
    o.JAID = c.JAID AND EndDate IS NULL AND c.LocationID = l.LocationID AND l.RegionID = r.RegionID
        AND l.RegionID = '" . $id ."';";

		foreach (returnDB()->query($offender_sql) as $row) {

			$offender_arr[] = array(
				'JAID' => $row['JAID'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'OptedIn' => $row['OptedIn'],
				'SiteName' => $row['SiteName'],
				'RegionName' => $row['RegionName'],


			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	return $offender_arr;
}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function client_output($arr) {
	$client_obj = array(
		'Clients' => $arr
	);
	
	return $client_obj;
}