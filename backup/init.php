<?php

$db = require_once "db.php";
$db->exec("CREATE TABLE customers (id INTEGER PRIMARY KEY, name TEXT, phone TEXT, phone_status TEXT);");