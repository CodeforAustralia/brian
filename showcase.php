<?php 

header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Origin: http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com:3000");
header("Content-Type:application/json");

require_once "send_message.php";

$id = 'IPSUM';
$to = $_GET['to'];
$from = $_GET['from'];
$content = $_GET['content'];

if(isset($_GET["to"]) && !empty($_GET["to"])) {
	sendMsg($id, $to, $from, $content);
}
