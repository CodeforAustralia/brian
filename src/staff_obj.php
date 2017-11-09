<?php
require_once "db.php";
require_once "pretty_json.php";



function get_all_staff() {
	try {
		$user_sql = "SELECT 
    *
FROM
    testdb.Staff s
        JOIN
    testdb.StaffAuthentication a
        JOIN
    testdb.StaffLocation sl
        JOIN
    testdb.Location l
WHERE
    s.email = sl.email
		    AND
		    s.email = a.email
        AND sl.LocationID = l.LocationID
        AND a.Authenticated = 1;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
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
    testdb.Staff s
        JOIN
    testdb.StaffAuthentication a
        JOIN
    testdb.StaffLocation sl
        JOIN
    testdb.Location l
WHERE
    s.email = sl.email
		    AND
		    s.email = a.email
        AND sl.LocationID = l.LocationID
        AND a.Authenticated = 1
        AND sl.LocationID = '" . $id . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
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
    testdb.OffenderAssignedToStaff s
        JOIN
    testdb.OffenderCCSLocation cl
        JOIN
    testdb.Location l
WHERE
    o.JAID = s.JAID AND s.JAID = cl.JAID
        AND cl.LocationID = l.LocationID
        AND cl.EndDate IS NULL
        AND o.OptedIn = 1
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

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function staff_output($arr) {
	$user_obj = array(
		'Staff' => $arr
	);
	
	return $user_obj;
}