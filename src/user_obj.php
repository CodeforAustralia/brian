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
	// return user_output($user_arr);
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
	// return user_output($user_arr);
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