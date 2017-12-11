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
								ON o.Username=s.Username
					WHERE 
						s.JAID = '". $JAID . "' ORDER BY EndDate ASC;";

		foreach(returnDB()->query($manager_sql) as $row) {
			$manager_arr[] = array(
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'Username' => $row['Username'],
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
    testdb.OffenderCCSLocation c ON o.JAID = c.JAID
    JOIN
    testdb.Location l ON c.LocationID = l.LocationID
WHERE
     EndDate IS NULL
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

function get_client_orders($JAID) {

	try {
		$offender_sql = "SELECT 
    *
FROM
    testdb.OffenderOrder o
        JOIN
    testdb.OrderType t ON o.OrderTypeID = t.OrderTypeID
WHERE
    JAID = '" . $JAID . "';";

		foreach (returnDB()->query($offender_sql) as $row) {

			$offender_arr[] = array(
				'OrderID' => $row['OrderID'],
				'OrderTypeID' => $row['OrderTypeID'],
				'OrderName' => $row['OrderName'],
				'Status' => $row['Status'],
				'StartDate' => $row['StartDate'],
				'EndDate' => $row['EndDate']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	return $offender_arr;
}

function get_client_conditions_from_order($JAID, $id) {

	try {
		$offender_sql = "SELECT 
    *
FROM
    testdb.OffenderCondition o
        JOIN
    testdb.ConditionType c ON o.TypeID = c.TypeID
WHERE
    JAID = '" . $JAID . "' AND OrderID = '" . $id . "';";

		foreach (returnDB()->query($offender_sql) as $row) {

			$offender_arr[] = array(
				'ConditionID' => $row['ConditionID'],
				'OrderID' => $row['OrderID'],
				'StartDate' => $row['StartDate'],
				'EndDate' => $row['EndDate'],
				'TypeID' => $row['TypeID'],
				'ConditionStatus' => $row['ConditionStatus'],
				'Detail' => $row['Detail'],
				'ConditionName' => $row['ConditionName'],
				'ConditionSlug' => $row['ConditionSlug'],
				'ConditionDescription' => $row['ConditionDescription']
			);
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	return $offender_arr;
}

function set_client_condition($JAID, $order_id, $type_id, $start_date, $end_date, $status, $detail) {
	try {

		$user_sql = "UPDATE testdb.OffenderCondition
SET 
    StartDate = '" . $start_date . "',
    EndDate = '" . $end_date . "',
    OrderStatus = '" . $status . "',
    Detail = '" . $detail . "'
WHERE
    OrderID = '" . $order_id . "' AND JAID = '" . $JAID . "'
        AND TypeID = '" . $type_id . "';";

		$user_query = returnDB()->query($user_sql);

		if($user_query)
			return 1;
		else
			return 0;

	} catch (Exception $e) {
		return 0;
	}
}

function get_client_list_in_region($id) {

	try {
		$offender_sql = "SELECT 
    *
FROM
    testdb.Offender o
        JOIN
    testdb.OffenderCCSLocation c ON o.JAID = c.JAID
        JOIN
    testdb.Location l ON c.LocationID = l.LocationID
        JOIN
    testdb.Region r ON l.RegionID = r.RegionID
WHERE
    EndDate IS NULL AND l.RegionID = '" . $id ."';";

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

function set_new_client($assignedstaff, $location, $firstname, $lastname, $JAID, $optedin, $username) {

	$curr_date = date('Y-m-d h:i:s', time());

	try {
		if($username != '') {
			$offender_sql = "INSERT INTO testdb.Offender (FirstName, LastName, Username, OptedIn) VALUES ('" . $firstname . "', '" . $lastname . "', '" . $username . "', '" . $optedin . "');";
			$offender_query = returnDB()->query($offender_sql);
			
			try {
				$offender_id_sql = "SELECT * FROM testdb.Offender WHERE Username = '" . $username . "';";

				foreach(returnDB()->query($offender_id_sql) as $row) {
					$JAID = $row['JAID'];
				}

			} catch (Exception $e) {
			    echo "Database Error!";
			}
		}
		else {
			$offender_sql = "INSERT INTO testdb.Offender (JAID, FirstName, LastName, OptedIn) VALUES ('" . $JAID . "', '" . $firstname . "', '" . $lastname . "', '" . $optedin . "');";
			$offender_query = returnDB()->query($offender_sql);	
		}

		if($offender_query) {
			$location_sql = "INSERT INTO testdb.OffenderCCSLocation (JAID, LocationID, StartDate) VALUES ('" . $JAID . "', '" . $location . "', '" . $curr_date . "');";
			$location_query = returnDB()->query($location_sql);

			if($location_query) {
				$auth_sql = "INSERT INTO testdb.OffenderAssignedToStaff (JAID, Username, StartDate) VALUES ('" . $JAID . "', '" . $assignedstaff . "', '" . $curr_date . "');";
				$auth_query = returnDB()->query($auth_sql);

				$order_sql = "INSERT INTO testdb.OffenderOrder (JAID, OrderTypeID, Status, StartDate) VALUES ('" . $JAID . "', '0', 'CUR', '" . $curr_date . "');";
				$order_query = returnDB()->query($order_sql);

				$order_ID = NULL;

				if($order_query) {

					try {
						$user_sql = "SELECT * FROM testdb.OffenderOrder WHERE JAID = '" . $JAID . "' AND StartDate = '" . $curr_date . "';";

						foreach(returnDB()->query($user_sql) as $row) {
							$order_ID = $row['OrderID'];
						}

					} catch (Exception $e) {
					    echo "Database Error!";
					}

					$condition_sql = "INSERT INTO testdb.OffenderCondition (OrderID, JAID, TypeID) VALUES 
						('" . $order_ID . "', '" . $JAID . "', '1'),
						('" . $order_ID . "', '" . $JAID . "', '2'), 
						('" . $order_ID . "', '" . $JAID . "', '3'), 
						('" . $order_ID . "', '" . $JAID . "', '4'), 
						('" . $order_ID . "', '" . $JAID . "', '5'), 
						('" . $order_ID . "', '" . $JAID . "', '6'), 
						('" . $order_ID . "', '" . $JAID . "', '7'), 
						('" . $order_ID . "', '" . $JAID . "', '8'), 
						('" . $order_ID . "', '" . $JAID . "', '9'), 
						('" . $order_ID . "', '" . $JAID . "', '10'),
						('" . $order_ID . "', '" . $JAID . "', '12'), 
						('" . $order_ID . "', '" . $JAID . "', '13'), 
						('" . $order_ID . "', '" . $JAID . "', '14'), 
						('" . $order_ID . "', '" . $JAID . "', '15'), 
						('" . $order_ID . "', '" . $JAID . "', '16'), 
						('" . $order_ID . "', '" . $JAID . "', '18'), 
						('" . $order_ID . "', '" . $JAID . "', '19'),
						('" . $order_ID . "', '" . $JAID . "', '20');";
						
					$condition_query = returnDB()->query($condition_sql);

				}
			}
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function client_output($arr) {
	$client_obj = array(
		'Clients' => $arr
	);
	
	return $client_obj;
}