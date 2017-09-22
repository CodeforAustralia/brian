<?php

require_once "db.php";

date_default_timezone_set('Australia/Melbourne');

 // Input OK, save customer
try {

    $addResult = returnDB()->exec("INSERT INTO `testdb`.`Message` (`JAID`, `MessageContents`, `To`, `From`, `DateTriggered`) VALUES ('333', 'Test message', '+61481712864', '+61412757232', '" . date('Y-m-d h:i:s a', time()) . "');");        

    if ($addResult)
        echo "SUCCESS: Test message";
    else
        echo "FAILED: Test message";
    
} catch (Exception $e) {
    echo "<p>Database Error!</p>";
}  