<?php

require_once "request.php";
require_once "vendor/autoload.php";
require_once "db.php";

use MessageMedia\RESTAPI\Configuration;
use MessageMedia\RESTAPI\Api\MessagingApi;
use MessageMedia\RESTAPI\Model\NewMessage;
use MessageMedia\RESTAPI\Model\Messages;


Configuration::getDefaultConfiguration()->setUsername('deV7DoyXTsvEFfQqOhW0');
Configuration::getDefaultConfiguration()->setPassword('Mew8LexZreHGyfzhtL2n5ozFrNLGrX');

function sendMsg ($id, $to, $from, $content) {

    $generated_id = 'something';
    echo $id;
    
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
                    ),
                    'callback_url' => 'https://samaradionne.com/brian/callback.php'

                ])
            ]
        ]));

        // Set MMID in callback
         // Input OK, save customer
        // try {
        //     $addResult = returnDB()->exec("UPDATE testdb.Message SET MMID='" . $generated_id . "' WHERE MessageID='" . $id . "';");        

        //     if ($addResult)
        //         echo "<p>MMID Updated!";
        //     else
        //         echo "<p>MMID could not be saved!";
            
        // } catch (Exception $e) {
        //     echo "<p>Database Error!</p>";
        // }      

    } catch (Exception $e) {
        echo $e;
        echo "<p>Failed texting the customer.</p>";
    }
}
