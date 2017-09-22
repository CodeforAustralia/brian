<?php 

require_once 'add.php';
require_once "db.php";
// $get_msgs = $db->exec("SELECT * FROM testdb.Message; ");

$offender_sql = "SELECT * FROM testdb.Offender;";

foreach (returnDB()->query($offender_sql) as $row) {


    $JAID = $row['JAID'];
    $FirstName = $row['FirstName'];
    $LastName = $row['LastName'];

		echo '<h3>Offender: ' . $FirstName . ' ' . $LastName . ' ( ' . $JAID . ')</h3>';

		$message_sql = "SELECT * FROM testdb.Message WHERE JAID = " . $JAID . " ORDER BY DateDelivered ASC;";

		foreach (returnDB()->query($message_sql) as $row) {


		    echo "<strong>Date: </strong>" . date("F j, Y, g:i a", strtotime($row['DateDelivered'])) . "<br />";
		    echo "<strong>To: </strong>" . $row['To'] . "<br />";
		    echo "<strong>From: </strong>" . $row['From'] . "<br />";
		    echo "<strong>Message: </strong>" . $row['MessageContents'] . "<br />";
		    echo "<strong>Delivery Status: </strong>" . $row['DeliveryStatus'] . "<br /><br />";

		}
}


$waiting_msgs_sql = "SELECT * FROM testdb.Message WHERE MMID IS NULL;";

foreach (returnDB()->query($waiting_msgs_sql) as $row) {

    $MessageID = $row['MessageID'];
    $To = $row['To'];
    $From = $row['From'];
    $MessageContents = $row['MessageContents'];

    sendMsg($MessageID, $To, $From, $MessageContents);

}