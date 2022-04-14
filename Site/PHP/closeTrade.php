<?php
include_once "../PHP/dbConnection.php";
include_once "../PHP/AES.php";

var_dump($_GET);

$tradeID = $_GET["tradeID"];
$change = $_GET["change"];
$closeDate = date("Y-m-d");
$startingValue = $_GET["startingValue"];

closeTrade($tradeID, encrypt($closeDate), encrypt($change));

$amount = strval((floatval($change)+1) * floatval($startingValue));
$amount = number_format($amount, 2);
header("Location: ../Pages/withdraw.php?amount=".$amount);


