<?php

require_once "db.php";

date_default_timezone_set('Australia/Melbourne');

$toNumber = '+61481712864';

if(isset($_GET["phone"]) && !empty($_GET["phone"])) {
	$toNumber = '+' . $_GET['phone'];
}

 // Input OK, save customer
try {

    $addResult = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MessageContents`, `To`, `From`, `DateTriggered`, `Outboud`, `ResponseRequired`) VALUES ('333', 'Test message " . date('Y-m-d h:i:s a', time()) . "', '" . $toNumber . "', '+61400868219', '" . date('Y-m-d h:i:s a', time()) . "', '1', '1');");        

    if ($addResult)
        echo "SUCCESS: Test message";
    else
        echo "FAILED: Test message";
    
} catch (Exception $e) {
    echo "<p>Database Error!</p>";
}  