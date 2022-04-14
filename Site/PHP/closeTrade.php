<?php
include_once "../PHP/dbConnection.php";
include_once "../PHP/AES.php";

var_dump($_GET);

$tradeID = $_GET["tradeID"];
$change = encrypt($_GET["change"]);
$closeDate = encrypt(date("Y-m-d"));

closeTrade($tradeID, $closeDate, $change);


