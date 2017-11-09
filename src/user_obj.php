<?php
require_once "db.php";
require_once "pretty_json.php";

date_default_timezone_set('Australia/Melbourne');

function get_all_users() {

	try {
		$user_sql = "SELECT * FROM testdb.User ORDER BY UserRole ASC;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username'],
				'UserRole' => $row['UserRole']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}


function get_user($user) {

	try {
		$user_sql = "SELECT * FROM testdb.User WHERE Username = '" . $user . "';";

		foreach(returnDB()->query($user_sql) as $row) {
			$user_arr[] = array(
				'Username' => $row['Username'],
				'UserRole' => $row['UserRole']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}



function get_all_types() {
	try {
		$user_sql = "SELECT DISTINCT UserRole FROM testdb.User;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserRole' => $row['UserRole']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}


function get_users_of_type($role) {
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

function get_users_from_location($id) {
	try {

		$user_sql = "SELECT 
			    *
			FROM
			    testdb.Staff s
			        JOIN
			    testdb.StaffLocation l ON s.email = l.email
			WHERE
			     LocationID = '" . $id . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'email' => $row['email'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}


function get_typed_users_from_location($id, $role) {
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
				WHERE u.UserRole = 'Offender' AND c.LocationID = '". $id ."'";
		}

		else {

			$user_sql = "
				SELECT
				    *
				FROM
				    testdb.User u
				        JOIN
				    testdb.Staff s ON u.Username = s.email
								JOIN
					testdb.StaffLocation l ON s.email = l.email
				WHERE u.UserRole = '" . $role . "' AND 
				    l.LocationID = '". $id ."'";
		}
    
		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username'],
				'FirstName' => $row['FirstName'],
				'LastName' => $row['LastName']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}


function get_waiting_authentication() {
	try {
		$user_sql = "SELECT * FROM testdb.User WHERE Authenticated = 0;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username'],
				'UserRole' => $row['UserRole']
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
    testdb.StaffLocation l ON u.Username = l.email
        JOIN
    testdb.StaffAuthentication a ON u.Username = a.email
WHERE
    a.LocationID = '" . $id . "'
        AND Authenticated = 0;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username'],
				'UserRole' => $row['UserRole']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}



function set_user_authentication($username, $id) {
	try {
		$user_sql = "UPDATE testdb.StaffAuthentication 
		SET 
		    Authenticated = '1'
		WHERE
		    email = '" . $username . "'
		        AND LocationID = '" . $id . "';";

		returnDB()->query($user_sql);

	} catch (Exception $e) {
		return;
	}
	return 1;
}

function set_user_role($username, $role) {

	try {
		$user_sql = "UPDATE testdb.User SET UserRole = '" . $role . "' WHERE Username = '" . $username . "';";

		returnDB()->query($user_sql);

	} catch (Exception $e) {
		return;
	}
	return 1;
}

function set_new_user($username, $password, $role, $location, $firstname, $lastname, $auth) {

	try {
		$user_sql = "INSERT INTO testdb.User (Username, Password, UserRole) VALUES ('" . $username . "', '" . $password . "', '" . $role . "');";
		returnDB()->query($user_sql);


		// Look into this for Offenders later
		if ($role == 'Staff') {
			$staff_sql = "INSERT INTO testdb.Staff (email, FirstName, LastName) VALUES ('" . $username . "', '" . $firstname . "', '" . $lastname . "');";
		returnDB()->query($staff_sql);

			$location_sql = "INSERT INTO testdb.StaffLocation (email, LocationID, StartDate, EndDate) VALUES ('" . $username . "', '" . $location . "', '" . date('Y-m-d h:i:s', time()) . "', NULL);";
			returnDB()->query($location_sql);

			$auth_sql = "INSERT INTO testdb.StaffAuthentication (email, LocationID, Authenticated) VALUES ('" . $username . "', '" . $location . "', '" . $auth . "');";
			returnDB()->query($auth_sql);
		}

	} catch (Exception $e) {
		return;
	}
	return 1;
}



// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function user_output($arr) {
	$user_obj = array(
		'Users' => $arr
	);
	
	return $user_obj;
}