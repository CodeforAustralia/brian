<?php
require_once "db.php";
require_once "pretty_json.php";


// Get all groups
function get_all_groups() {

	try {
		$group_sql = "SELECT * FROM testdb.Group;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'GroupLocation' => $row['GroupLocation'],
				'GroupType' => $row['GroupType'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
				'Archived' => $row['Archived'],
				'ArchiveDate' => $row['ArchiveDate'],
				'Archivist' => $row['Archivist'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get specific group
function get_group($id) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupID = '" . $id . "';";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'GroupLocation' => $row['GroupLocation'],
				'GroupType' => $row['GroupType'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
				'Archived' => $row['Archived'],
				'ArchiveDate' => $row['ArchiveDate'],
				'Archivist' => $row['Archivist'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get groups of a specific type
function get_group_of_type($type) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupType = '" . $type . "';";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'GroupLocation' => $row['GroupLocation'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
				'Archived' => $row['Archived'],
				'ArchiveDate' => $row['ArchiveDate'],
				'Archivist' => $row['Archivist'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get groups made by a staff member
function get_staff_groups($author) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupAuthor = '" . $author . "' AND Archived = 0;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupLocation' => $row['GroupLocation'],
				'GroupType' => $row['GroupType'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get groups made by a staff member of type
function get_staff_groups_of_type($author, $type) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupAuthor = '" . $author . "' AND GroupType = '" . $type . "' AND Archived = 0;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupLocation' => $row['GroupLocation'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}


// Get archived groups made by a staff member of type
function get_archived_staff_groups_of_type($author, $type) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupAuthor = '" . $author . "' AND GroupType = '" . $type . "' AND Archived = 1;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupLocation' => $row['GroupLocation'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated']
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get groups of type
function get_group_type($type) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupType = '" . $type . "';";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'GroupLocation' => $row['GroupLocation'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
				'Archived' => $row['Archived'],
				'ArchiveDate' => $row['ArchiveDate'],
				'Archivist' => $row['Archivist'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get groups at a location
function get_group_location($id) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupLocation = '" . $id . "' AND Archived = 0;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get archived groups at a location
function get_group_location_archived($id) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupLocation = '" . $id . "' AND Archived = 1;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
				'Archived' => $row['Archived'],
				'ArchiveDate' => $row['ArchiveDate'],
				'Archivist' => $row['Archivist'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get groups at a location of type
function get_group_location_of_type($id, $type) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupLocation = '" . $id . "' AND GroupType = '" . $type . "' AND Archived = 0;";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

// Get archived groups at a location of type
function get_group_location_of_type_archived($id, $type) {

	try {
		$group_sql = "SELECT * FROM testdb.Group WHERE GroupLocation = '" . $id . "' AND GroupType = '" . $type . "' AND Archived = 1";

		foreach(returnDB()->query($group_sql) as $row) {

			$group_arr[] = array(
				'GroupID' => $row['GroupID'],
				'GroupName' => $row['GroupName'],
				'GroupAuthor' => $row['GroupAuthor'],
				'DateCreated' => $row['DateCreated'],
				'LastUpdatedAuthor' => $row['LastUpdatedAuthor'],
				'LastUpdated' => $row['LastUpdated'],
				'Archived' => $row['Archived'],
				'ArchiveDate' => $row['ArchiveDate'],
				'Archivist' => $row['Archivist'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	return $group_arr;
}

function set_new_group($name, $author, $location, $type) {

	$curr_date = date('Y-m-d h:i:s', time());
	$group_ID = '';

	try {

		$user_sql = "INSERT INTO testdb.Group (GroupName, GroupAuthor, GroupLocation, GroupType, DateCreated) VALUES ('" . $name . "', '" . $author . "', '" . $location . "', '" . $type . "', '" . $curr_date . "');";
		$user_query = returnDB()->query($user_sql);

		if($user_query) {

			try {

				$group_sql = "SELECT * FROM testdb.Group WHERE GroupName = '" . $name . "' AND GroupAuthor = '" . $author . "' AND GroupLocation = '" . $location . "' AND GroupType = '" . $type . "' AND DateCreated = '" . $curr_date . "';";

				foreach(returnDB()->query($group_sql) as $row) {
					$group_ID = $row['GroupID'];
				}

			} catch (Exception $e) {
				return NULL;
			}
		}
		return $group_ID;

	} catch (Exception $e) {
		return NULL;
	}
}