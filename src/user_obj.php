<?php
require_once "db.php";
require_once "pretty_json.php";


function get_users() {

	try {
		$user_sql = "SELECT * FROM testdb.User ORDER BY UserRole ASC;";

		foreach(returnDB()->query($user_sql) as $row) {

			$user_arr[] = array(
				'UserName' => $row['UserName'],
				'UserRole' => $row['UserRole']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return client_output($user_arr);
}


function get_user($user) {

	try {
		$user_sql = "SELECT * FROM testdb.User WHERE Username = '" . $user . "';";

		foreach(returnDB()->query($user_sql) as $row) {
			$user_arr[] = array(
				'UserRole' => $row['UserRole']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return client_output($user_arr);
}

// Get CCS locations in ascending order of EndDate
function get_user_types() {

	} catch (Exception $e) {
	    echo "<p>Database Error!</p>";
	}

	return $ccs_location_arr;
}

// Create JSON encoded object to be served with previous array data
// TODO: Condense all of these outputs
function client_output($arr) {
	$user_obj = array(
		'Users' => $arr
	);
	
	return $user_obj;
}