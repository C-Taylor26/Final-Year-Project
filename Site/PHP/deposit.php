<?php
if (!isset($_SESSION)){
    session_start();
}

include_once "dbConnection.php";

newPosition($_POST["value"], $_SESSION["email"]);

header("Location: ../Pages/account.php");