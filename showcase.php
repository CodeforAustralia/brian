<?php 

require_once "add.php";

$id = 'IPSUM';
$to = $_GET['to'];
$from = $_GET['from'];
$content = $_GET['content'];

if(isset($_GET["to"]) && !empty($_GET["to"])) {
	sendMsg($id, $to, $from, $content);
}
