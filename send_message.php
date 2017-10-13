<?php

// require_once "request.php";
require_once "vendor/autoload.php";
require_once "db.php";

use MessageMedia\RESTAPI\Configuration;
use MessageMedia\RESTAPI\Api\MessagingApi;
use MessageMedia\RESTAPI\Model\NewMessage;
use MessageMedia\RESTAPI\Model\Messages;


Configuration::getDefaultConfiguration()->setUsername('koHTdXzRQzLEih7cX6Km');
Configuration::getDefaultConfiguration()->setPassword('wlhjeigGgrNcrNpL7iC0ACQEGuTUe3');

if((isset($_GET["JAID"]) && !empty($_GET["JAID"])) && (isset($_GET["to"]) && !empty($_GET["to"])) && (isset($_GET["content"]) && !empty($_GET["content"])) && (isset($_GET["response"]))) {

	try {
    $addResult = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MessageContents`, `To`, `From`, `DateTriggered`, `Outbound`, `ResponseRequired`) VALUES ('" . $_GET["JAID"] . "', '" . $_GET["content"] . "', '+" . $_GET["to"] . "', '+" . $_GET["from"] . "', '" . date('Y-m-d h:i:s a', time()) . "', '1', '" . $_GET["response"] . "');");        


    if ($addResult)
        echo "SUCCESS: Test message";
    else
        echo "FAILED: Test message";
	    
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
