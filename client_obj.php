<?php

// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://ec2-52-63-1-205.ap-southeast-2.compute.amazonaws.com:3000");
header("Content-Type:application/json");

require_once "db.php";
require_once "pretty_json.php";

$client_obj = '';

$JAID = '';
$FirstName = '';
$LastName = '';

$debug = '';

if(isset($_GET["debug"]) && !empty($_GET["debug"])) {
	$debug = $_GET['debug'];
}

if(isset($_GET["JAID"]) && !empty($_GET["JAID"])) {
	$JAID = $_GET['JAID'];

	$phone_Arr = array();
	$location_Arr = array();

	try {
		$offender_sql = "SELECT * FROM testdb.Offender WHERE JAID = " . $JAID . ";";

		foreach (returnDB()->query($offender_sql) as $row) {

			$JAID = $row['JAID'];
			$FirstName = $row['FirstName'];
			$LastName = $row['LastName'];
		}
	} catch (Exception $e) {
	    echo "Database Error";
	}

	try {
		$phone_sql = "SELECT * FROM testdb.Phone WHERE JAID = " . $JAID . ";";

		foreach(returnDB()->query($phone_sql) as $row) {

			$phone_Arr[] = array(
				'PhoneNumber' => $row['PhoneNumber'],
				'StartDate' => $row['StartDate'],
				'EndDate' => $row['EndDate'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}

	try {
			$location_sql = "SELECT 
		* 
	FROM 
		testdb.Offender o
			JOIN testdb.OffenderCCSLocation c
				ON o.JAID=c.JAID
			JOIN testdb.Location l
				ON c.LocationID=l.LocationID
	WHERE 
		o.JAID = '". $JAID . "';";

		foreach(returnDB()->query($location_sql) as $row) {

			$location_Arr[] = array(
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


	try {
		$message_sql = "SELECT * FROM testdb.Message WHERE JAID = " . $JAID . " ORDER BY DateDelivered ASC;";

		foreach(returnDB()->query($message_sql) as $row) {

			$message_Arr[] = array(
				'MessageType' => $row['MessageType'],
				'Outbound' => $row['Outbound'],
				'To' => $row['To'],
				'From' => $row['From'],
				'MessageContents' => $row['MessageContents'],
				'DeliveryStatus' => $row['DeliveryStatus'],
				'DateDelivered' => $row['DateDelivered'],
			);
		}

	} catch (Exception $e) {
	    echo "Database Error!";
	}



	$client_obj = array(
		'JAID' => $JAID,
		'FirstName' => $FirstName,
		'LastName' => $LastName,
		'Phones' => $phone_Arr,
		'Locations' => $location_Arr,
		'Messages' => $message_Arr
	);
	
	$json_client_obj = json_encode($client_obj);

	if($debug) {
		print "<pre>";
		print_r(indent($json_client_obj));
		print "</pre>";
	}
	else {
		$json_client_obj = json_encode($client_obj);
		echo $json_client_obj;
	}
	
	// if(empty($price))	{
	// 	response(200,"Product Not Found",NULL);
	// }
	// else {
	// 	response(200,"Product Found",$json_client_obj);
	// }

}
else {
	// response(400,"Invalid Request",NULL);
}

// function response($status,$status_message,$data) {
// 	header("HTTP/1.1 ".$status_message);
	
// 	$response['status']=$status;
// 	$response['status_message']=$status_message;
// 	$response['data']=$data;
	
// 	$json_response = json_encode($response);
// 	echo $json_response;
// }