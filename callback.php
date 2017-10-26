<?php

require_once "db.php";
require_once "check_status.php";

date_default_timezone_set('Australia/Melbourne');

$jsonData = json_decode(file_get_contents('php://input'), true);

$dump = '';

$file = 'debug.log';
$dump = date('Y-m-d h:i:s a', time()) . ' - ' . print_r($jsonData);



$dump .= 'format: ' . $jsonData['format'];
$dump .= 'content: ' . $jsonData['content'];
$dump .= 'MessageID: ' . $jsonData['metadata']['MessageID'];
$dump .= 'message_id: ' . $jsonData['message_id'];
$dump .= 'message_expiry_timestamp: ' . $jsonData['message_expiry_timestamp'];
$dump .= 'scheduled: ' . $jsonData['scheduled'];
$dump .= 'callback_url: ' . $jsonData['callback_url'];
$dump .= 'delivery_report: ' . $jsonData['delivery_report'];
$dump .= 'destination_number: ' . $jsonData['destination_number'];
$dump .= 'source_number: ' . $jsonData['source_number'];
$dump .= 'status: ' . $jsonData['status'];

file_put_contents($file, $dump . "\n", FILE_APPEND | LOCK_EX);

if (isset($jsonData['status'])) {

    // $db->exec("UPDATE customers SET phone_status = ".$db->quote($jsonData['status'])." WHERE phone = ".$db->quote($jsonData['destination_number']));

    try {

        if (strcmp($jsonData['status'],"Delivered")) {
            $updateStatus = returnDB()->exec("UPDATE testdb.Message SET MMID='" . $jsonData['message_id'] . "', DeliveryStatus='" . $jsonData['status'] . "', DateDelivered='" . date('Y-m-d h:i:s a', time()) . "' WHERE MessageID='" . $jsonData['metadata']['MessageID'] . "';");
        }
        else {
            $updateStatus = returnDB()->exec("UPDATE testdb.Message SET MMID='" . $jsonData['message_id'] . "', DeliveryStatus='" . $jsonData['status'] . "', DateAttempted='" . date('Y-m-d h:i:s a', time()) . "' WHERE MessageID='" . $jsonData['metadata']['MessageID'] . "';");  
            checkStatus();
        }

	    if ($updateStatus)
	        echo "SUCCESS: Added Status & Message ID";
	    else
	        echo "FAILED: Added Status & Message ID";

        
    } catch (Exception $e) {
        echo "<p>Database Error!</p>";
    }


    if (in_array($jsonData['status'], ['rejected', 'failed'])) {
        // TODO: send a mail to admin
    }
};