<?php
include_once '../PHP/passwordHashing.php';
include_once '../PHP/settings.php';

if (!isset($_SESSION)){
    session_start();
}

include_once 'dbConnection.php';
if (isset($_POST["email"])) {
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["fname"] = $_POST["fname"];
    $_SESSION["lname"] = $_POST["lname"];
    $_SESSION["pw"] = hashPassword($_POST["pw"]);
    $user = getUser($_SESSION["email"]);
}
else{
    header("Location: ../Pages/index.php?error=500");
}
if (count($user) == 0) {
    header("Location: ../Pages/mfaSetup.php");
}
else {
    header("Location: ../Pages/index.php?error=duplicate-email");
}