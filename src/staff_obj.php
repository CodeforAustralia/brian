<?php
require_once "db.php";
require_once "pretty_json.php";



function get_all_staff() {
	try {
		$user_sql = "SELECT 
*SELECT 
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
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
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
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
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
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
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
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
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
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
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
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
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
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
WHERE
    cl.EndDate IS NULL AND o.OptedIn = 1
        AND cl.LocationID = '" . $id . "'
        AND s.email = '" . $username . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'JAID' => $row['JAID'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_waiting_authentication() {
	try {
		$user_sql = "SELECT 
    *
FROM
    testdb.User u
    		JOIN
    testdb.Staff s ON u.UserName = s.email
        JOIN
    testdb.StaffLocation sl ON u.UserName = sl.email
        JOIN
    testdb.StaffAuthentication a ON s.email = a.email AND sl.LocationID = a.LocationID
        JOIN
    testdb.Location l ON sl.LocationID = l.LocationID
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
WHERE
 Authenticated = 0;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserRole' => $row['UserRole'],
				'email' => $row['email'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_waiting_authentication_from_location($id) {
	try {

		
		$user_sql = "SELECT 
    *
FROM
    testdb.User u
    		JOIN
    testdb.Staff s ON u.UserName = s.email
        JOIN
    testdb.StaffLocation sl ON u.UserName = sl.email
        JOIN
    testdb.StaffAuthentication a ON s.email = a.email AND sl.LocationID = a.LocationID
        JOIN
    testdb.Location l ON sl.LocationID = l.LocationID
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
WHERE
    a.LocationID = '" . $id . "'
        AND Authenticated = 0;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserRole' => $row['UserRole'],
				'email' => $row['email'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}



function set_staff_authentication($username, $id, $status) {
	try {
		$user_sql = "UPDATE testdb.StaffAuthentication 
		SET 
		    Authenticated = '" . $status . "'
		WHERE
		    email = '" . $username . "'
		        AND LocationID = '" . $id . "';";

		returnDB()->query($user_sql);

	} catch (Exception $e) {
		return;
	}
	return 1;
}
function get_typed_staff_from_location($id, $role) {
	try {

		if($role == 'Offender') {
			$user_sql = "
				SELECT 
				    *
				FROM
				    testdb.User u
				        JOIN
				    testdb.OffenderCCSLocation c ON u.Username = c.JAID
                    JOIN
                    testdb.Location l ON c.LocationID = l.LocationID
                    JOIN
                    testdb.Region r ON l.RegionID = r.RegionID
				        JOIN
				    testdb.Offender o ON u.Username = o.JAID
				WHERE u.UserRole = 'Offender' AND c.LocationID = '". $id ."'";
		}

		else {

			$user_sql = "	SELECT
				    *
				FROM
				    testdb.User u
				        JOIN
				    testdb.Staff s ON u.Username = s.email
								JOIN
					testdb.StaffLocation sl ON sl.email = s.email
								JOIN
					testdb.Location l ON l.LocationID = sl.LocationID
                    JOIN
                    testdb.Region r ON l.RegionID = r.RegionID
				WHERE u.UserRole = '" . $role . "' AND 
				    l.LocationID = '". $id ."'";
		}
    
		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_staff_of_type($role) {
	try {


		if($role == 'Offender') {
			$user_sql = "
				SELECT 
				    *
				FROM
				    testdb.User u
				        JOIN
				    testdb.OffenderCCSLocation c ON u.Username = c.JAID
				        JOIN
				    testdb.Offender o ON u.Username = o.JAID
				        JOIN
				    testdb.Location l ON c.LocationID = l.LocationID
				        JOIN
				    testdb.Region r ON l.RegionID = r.RegionID
				WHERE u.UserRole = 'Offender'";
		}
		else {
			$user_sql = "SELECT 
				    *
				FROM
				    testdb.User u
				        JOIN
				    testdb.Staff s ON u.Username = s.email
				        JOIN
				    testdb.StaffLocation sl ON s.email = sl.email
				        JOIN
				    testdb.Location l ON sl.LocationID = l.LocationID
				        JOIN
				    testdb.Region r ON l.RegionID = r.RegionID
				WHERE
				    u.UserRole = '" . $role . "'";
		}


		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'SiteName' => $row['SiteName'],
				'RegionName' => $row['RegionName'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_revoked_staff() {
	try {
		$user_sql = "SELECT 
    *
FROM
    testdb.User u
    		JOIN
    testdb.Staff s ON u.UserName = s.email
        JOIN
    testdb.StaffLocation sl ON u.UserName = sl.email
        JOIN
    testdb.StaffAuthentication a ON s.email = a.email AND sl.LocationID = a.LocationID
        JOIN
    testdb.Location l ON sl.LocationID = l.LocationID
    JOIN
    testdb.Region r ON l.RegionID = r.RegionID
WHERE
 Authenticated = 3;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserRole' => $row['UserRole'],
				'email' => $row['email'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName'],
				'LocationID' => $row['LocationID'],
				'SiteName' => $row['SiteName'],
				'RegionID' => $row['RegionID'],
				'RegionName' => $row['RegionName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}



function delete_staff($username, $id) {
	try {

		// Should not need to check any other table as the Staff would not have been authenticated at a location yet
		$user_sql = "DELETE FROM testdb.StaffAuthentication WHERE email='" . $username . " and LocationID='" .$id . "';";
		returnDB()->query($user_sql);

		$user_sql = "DELETE FROM testdb.User WHERE Username='" . $username . "';";
		returnDB()->query($user_sql);

	} catch (Exception $e) {
		return;
	}
	return 1;
}



// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function staff_output($arr) {
	$user_obj = array(
		'Staff' => $arr
	);
	
	return $user_obj;
}