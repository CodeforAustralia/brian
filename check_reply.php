<?php

// require_once "request.php";
require_once "vendor/autoload.php";
require_once "db.php";
require_once "pretty_json.php";

use MessageMedia\RESTAPI\Configuration;
use MessageMedia\RESTAPI\Api\MessagingApi;
use MessageMedia\RESTAPI\Api\DeliveryReportsApi;
use MessageMedia\RESTAPI\Api\RepliesApi;
use MessageMedia\RESTAPI\Model\NewMessage;
use MessageMedia\RESTAPI\Model\Messages;


Configuration::getDefaultConfiguration()->setUsername('koHTdXzRQzLEih7cX6Km');
Configuration::getDefaultConfiguration()->setPassword('wlhjeigGgrNcrNpL7iC0ACQEGuTUe3');

function checkReply() {
    try {
        $RepliesApi = new RepliesApi;
        $result = $RepliesApi->checkReplies();

        $jsonData = json_decode($result, true);

        $reply_ID_array = array();

	    	foreach($jsonData['replies'] as $report) {

			    $addReply = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MMID`, `DeliveryStatus`, `MessageContents`, `Outbound`, `To`, `From`, `DateDelivered`) VALUES ('333', '" . $report['message_id'] . "', 'Delivered', '" . $report['content'] . "', '0', '" . $report['destination_number'] . "', '" . $report['source_number'] . "', '" . $report['date_received'] . "');");

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