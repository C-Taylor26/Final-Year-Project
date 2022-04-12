<?php

include_once 'dbConnection.php';
include_once 'settings.php';

if (!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION["email"])){
    header("Location: index.php");
}
var_dump($_SESSION);

try{
    createAccount($_SESSION["email"], $_SESSION["fname"], $_SESSION["lname"], $_SESSION["pw"], $_SESSION["token"]);

    unset($_SESSION["pw"]);
    unset($_SESSION["token"]);

    $_SESSION["auth"] = true;
    header("Location: ../Pages/overview.php");
}
catch (Exception $e){
    header("Location: ../Pages/index.php?error=500");
}







