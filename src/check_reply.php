<?php

// require_once "request.php";
require_once "vendor/autoload.php";
require_once "db.php";
require_once "pretty_json.php";
require_once "send_message.php";

use MessageMedia\RESTAPI\Configuration;
use MessageMedia\RESTAPI\Api\MessagingApi;
use MessageMedia\RESTAPI\Api\DeliveryReportsApi;
use MessageMedia\RESTAPI\Api\RepliesApi;
use MessageMedia\RESTAPI\Model\NewMessage;
use MessageMedia\RESTAPI\Model\Messages;

date_default_timezone_set('Australia/Melbourne');

Configuration::getDefaultConfiguration()->setUsername(getMMUsername());
Configuration::getDefaultConfiguration()->setPassword(getMMPassword());

function checkReply() {
    try {
        $RepliesApi = new RepliesApi;
        $result = $RepliesApi->checkReplies();

        $jsonData = json_decode($result, true);

        $reply_ID_array = array();

	    	foreach($jsonData['replies'] as $report) {

        	$received = date('Y-m-d h:i:s a', strtotime($report['date_received']));

			    $addReply = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MMID`, `DeliveryStatus`, `MessageContents`, `Outbound`, `To`, `From`, `DateDelivered`) VALUES ('333', '" . $report['message_id'] . "', 'Delivered', '" . $report['content'] . "', '0', '" . $report['destination_number'] . "', '" . $report['source_number'] . "', '" . $received . "');");

			    if ($addReply) {
						try {

							$ch = curl_init();

							curl_setopt($ch, CURLOPT_URL, "https://api.messagemedia.com/v1/replies/confirmed");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($ch, CURLOPT_HEADER, FALSE);

							curl_setopt($ch, CURLOPT_POST, TRUE);

							curl_setopt($ch, CURLOPT_POSTFIELDS, '{
							  "reply_ids":[
							    "' . $report['reply_id'] . '"
							  ]
							}');

							curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							  "Content-Type: application/json",
							  "Accept: application/json",
							  "Authorization: Basic a29IVGRYelJRekxFaWg3Y1g2S206d2xoamVpZ0dnck5jck5wTDdpQzBBQ1FFR3VUVWUz"
							));

							$response = curl_exec($ch);
							curl_close($ch);

						} catch (Exception $e) {
					    echo 'Exception when calling RepliesApi->confirmReplies: ', $e->getMessage(), PHP_EOL;
						}
				if (strcmp($report['content'], "N") == 0) {
					sendMsg($report['message_id'], '333', $report['source_number'], $report['destination_number'], "Thanks for letting us know. We will call you on 0" . substr($report['source_number'], 3) . " to reschedule.");
				}
		      }
			    else 
			        echo "FAILED: Test message";
	    	}

				// print "<pre>";
        // print_r($message_ID_array);  
				// print "</pre>";

    } catch (Exception $e) {
        echo $e;
		    echo 'Exception when calling RepliesApi->checkReplies: ', $e->getMessage(), PHP_EOL;
    }
}
