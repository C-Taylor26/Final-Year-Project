<?php

include_once "dbConnection.php";
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_GET["action"])){
    header("Location: ../Pages/overview.php");
}

if ($_GET["action"] === "deposit"){
    #deposit stuff
    #take input
    $input = $_POST["amount"];

    #amount must be at least $10 and only have 2 decimal places

    #validate
    #db connection
    header("Location: ../Pages/accountPage.php?r=200");
}
if ($_GET["action"] === "withdraw"){
    #withdrawal stuff
    header("Location: ../Pages/accountPage.php?r=200");
}
else {
    header("Location: ../Pages/overview.php");
}

