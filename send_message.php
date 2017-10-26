<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");

// require_once "request.php";
require_once "vendor/autoload.php";
require_once "db.php";

use MessageMedia\RESTAPI\Configuration;
use MessageMedia\RESTAPI\Api\MessagingApi;
use MessageMedia\RESTAPI\Model\NewMessage;
use MessageMedia\RESTAPI\Model\Messages;

date_default_timezone_set('Australia/Melbourne');

Configuration::getDefaultConfiguration()->setUsername('koHTdXzRQzLEih7cX6Km');
Configuration::getDefaultConfiguration()->setPassword('wlhjeigGgrNcrNpL7iC0ACQEGuTUe3');

if((isset($_GET["JAID"]) && !empty($_GET["JAID"])) && (isset($_GET["to"]) && !empty($_GET["to"])) && (isset($_GET["content"]) && !empty($_GET["content"])) && (isset($_GET["response"]))) {

	try {
        $addResult = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MessageContents`, `To`, `From`, `DateTriggered`, `DateDelivered`, `Outbound`, `MessageType`, `ResponseRequired`) VALUES ('" . $_GET["JAID"] . "', '" . $_GET["content"] . "', '+" . $_GET["to"] . "', '+" . $_GET["from"] . "', '" . date('Y-m-d H:i:s', time()) . "', '" . date('Y-m-d H:i:s', time()) . "', '0', 'App', '" . $_GET["response"] . "');");        

        if ($addResult) {
            echo "SUCCESS: Test message";
        	if (strcmp($_GET["content"], "Reschedule") == 0)
        		$responseMsg = "Thanks for letting us know. We will call you on 0" . substr($_GET["from"], 2) . " to reschedule.";
        	else if (strcmp($_GET["content"], "OK") == 0)
        		$responseMsg = "Thank you. See you soon.";
        	else
        		$responseMsg = "Your case manager will call you on 0" . substr($_GET["from"], 2) . ". If you need help straight away, please call 000.";

        	$response = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MessageContents`, `To`, `From`, `DateTriggered`, `DateDelivered`, `Outbound`, `MessageType`, `ResponseRequired`) VALUES ('" . $_GET["JAID"] . "', '" . $responseMsg . "', '+" . $_GET["from"] . "', '+" . $_GET["to"] . "', '" . date('Y-m-d H:i:s', time()) . "', '" . date('Y-m-d H:i:s', time()) . "', '1', 'App', '0');");

        	if ($response)
        		echo "SUCCESS: Auto Response";
        	else
        		echo "FAILURE: Auto Response";
        } 
        else {
            echo "FAILED: Test message";
        }
	    
	} catch (Exception $e) {
	    echo "<p>Database Error!</p>";
	}  

}


function sendMsg ($id, $JAID, $to, $from, $content) {
    
    try {
        $messagingApi = new MessagingApi;
        
        $messagingApi->sendMessages(new Messages([
            'messages' => [
                new NewMessage([
                    'content' => $content,
                    'destination_number' => $to,
                    'source_number' => $from,
                    'delivery_report' => true,
                    'metadata' => array(
                        'MessageID' => $id,
                        'JAID' => $JAID,
                    ),
                    'callback_url' => 'http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com/brian/callback.php'

                ])
            ]
        ])); 

    } catch (Exception $e) {
        echo $e;
        echo "<p>Failed texting the customer.</p>";
    }
}
