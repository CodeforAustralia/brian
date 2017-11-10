<?php
require_once "db.php";
require_once "pretty_json.php";



function get_all_staff() {
	try {
		$user_sql = "SELECT 
*
FROM
	testdb.User u
		JOIN 
    testdb.Staff s ON u.Username = s.email
        JOIN
    testdb.StaffLocation sl ON s.email = sl.email
        JOIN
    testdb.StaffAuthentication a ON s.email = a.email AND sl.LocationID = a.LocationID
        JOIN
    testdb.Location l ON a.LocationID = l.LocationID
WHERE
        a.Authenticated = 1;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserRole' => $row['UserRole'],
				'email' => $row['email'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_staff_from_location($id) {
	try {

		$user_sql = "SELECT 
*
FROM
	testdb.User u
		JOIN 
    testdb.Staff s ON u.Username = s.email
        JOIN
    testdb.StaffLocation sl ON s.email = sl.email
        JOIN
    testdb.StaffAuthentication a ON s.email = a.email AND sl.LocationID = a.LocationID
        JOIN
    testdb.Location l ON a.LocationID = l.LocationID
WHERE
        a.Authenticated = 1
        AND sl.LocationID = '" . $id . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserRole' => $row['UserRole'],
				'email' => $row['email'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_staff_clients($username) {
	try {
		$user_sql = "SELECT 
    *
FROM
    testdb.Offender o
        JOIN
    testdb.OffenderAssignedToStaff s ON o.JAID = s.JAID
        JOIN
    testdb.OffenderCCSLocation cl ON s.JAID = cl.JAID
        JOIN
    testdb.Location l ON cl.LocationID = l.LocationID
WHERE
    cl.EndDate IS NULL AND o.OptedIn = 1
        AND s.email = '" . $username . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'JAID' => $row['JAID'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_staff_clients_from_location($username, $id) {
	try {
		$user_sql = "SELECT 
    *
FROM
    testdb.Offender o
        JOIN
    testdb.OffenderAssignedToStaff s ON o.JAID = s.JAID
        JOIN
    testdb.OffenderCCSLocation cl ON s.JAID = cl.JAID
        JOIN
    testdb.Location l ON cl.LocationID = l.LocationID
WHERE
    cl.EndDate IS NULL AND o.OptedIn = 1
        AND cl.LocationID = '" . $id . "'
        AND s.email = " . $username . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'JAID' => $row['JAID'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function staff_output($arr) {
	$user_obj = array(
		'Staff' => $arr
	);
	
	return $user_obj;
}