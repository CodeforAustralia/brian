<?php

// require_once "request.php";
require_once "vendor/autoload.php";
// require_once "db.php";
require_once "pretty_json.php";

use MessageMedia\RESTAPI\Configuration;
use MessageMedia\RESTAPI\Api\MessagingApi;
use MessageMedia\RESTAPI\Api\DeliveryReportsApi;
use MessageMedia\RESTAPI\Model\NewMessage;
use MessageMedia\RESTAPI\Model\Messages;


Configuration::getDefaultConfiguration()->setUsername('koHTdXzRQzLEih7cX6Km');
Configuration::getDefaultConfiguration()->setPassword('wlhjeigGgrNcrNpL7iC0ACQEGuTUe3');


function checkStatus() {    
    try {
        $DeliveryReportsApi = new DeliveryReportsApi;
        $result = $DeliveryReportsApi->checkReports();

        $jsonData = json_decode($result, true);

        $message_ID_array = array();

	    	foreach($jsonData['delivery_reports'] as $report) {
	    		$message_ID_array[] = $report['delivery_report_id'];
	    	}

        $encoded_message_ID_array = json_encode($message_ID_array);

				try {

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, "https://api.messagemedia.com/v1/delivery_reports/confirmed");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);

					curl_setopt($ch, CURLOPT_POST, TRUE);

					curl_setopt($ch, CURLOPT_POSTFIELDS, '{
					  "delivery_report_ids": ' . $encoded_message_ID_array . '
					}');

					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					  "Content-Type: application/json",
					  "Accept: application/json",
					  "Authorization: Basic a29IVGRYelJRekxFaWg3Y1g2S206d2xoamVpZ0dnck5jck5wTDdpQzBBQ1FFR3VUVWUz"
					));

					$response = curl_exec($ch);
					curl_close($ch);

				} catch (Exception $e) {
				    echo 'Confirming messages failed: ', $e->getMessage(), PHP_EOL;
				}

				print "<pre>";
        print_r($message_ID_array);  
				print "</pre>";

    } catch (Exception $e) {
        echo $e;
        echo 'Exception when calling DeliveryReportsApi->checkReports: ', $e->getMessage(), PHP_EOL;
    }
}