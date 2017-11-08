<?php
require_once "db.php";
require_once "pretty_json.php";


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
		$user_sql = "SELECT * FROM testdb.User WHERE UserRole = '" . $role . "';";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'Username' => $row['Username']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $user_arr;
}

function get_users_from_location($id) {
	try {

		$user_sql = "SELECT * FROM testdb.Staff s JOIN testdb.StaffLocation l WHERE s.email = l.email AND LocationID = '" . $id . "';";

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
				        LEFT JOIN
				    testdb.OffenderCCSLocation c ON u.Username = c.JAID
				        LEFT JOIN
				    testdb.Offender o ON u.Username = o.JAID
				WHERE u.UserRole = 'Offender' AND c.LocationID = '". $id ."'";
		}

		else {

			$user_sql = "
				SELECT
				    *
				FROM
				    testdb.User u
				        LEFT JOIN
				    testdb.Staff s ON u.Username = s.email
				WHERE u.UserRole = '" . $role . "' AND 
				    s.LocationID = '". $id ."'";
		}
    
    

	// Works, but don't use it for now
	// 		$user_sql = "
	// 			SELECT 
	//     *
	// FROM
	//     testdb.User u
	//         LEFT JOIN
	//     testdb.Staff s ON u.Username = s.email
	//         LEFT JOIN
	//     testdb.OffenderCCSLocation o ON u.Username = o.JAID
	// WHERE
	//     (u.UserRole = '" . $role . "') AND (s.LocationID = '". $id . "' OR o.LocationID = '". $id . "');";

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
	// return user_output($user_arr);

}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function user_output($arr) {
	$user_obj = array(
		'Users' => $arr
	);
	
	return $user_obj;
}