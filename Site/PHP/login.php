<?php
include_once "dbConnection.php";
include_once "settings.php";

if (!isset($_SESSION)){
    session_start();
}

$email = $_POST["email"];
$pw = $_POST["pw"];

$saltedPW = SALT . $pw;

$user = getUser($email);
$login = false;
if (count($user)>0) {
    $pwActual = $user[0]["password"];

    for ($i = 0; $i < strlen(PEPPER_CHARS); $i++) {
        $testPW = $saltedPW . PEPPER_CHARS[$i];
        $testHash = strtoupper(hash("sha256", $testPW));
        if ($testHash === $pwActual) {
            $login = true;
        }
    }
}
if ($login === true){
    $_SESSION["email"] = $user[0]["ID"];
    $_SESSION["fname"] = $user[0]["fName"];
    $_SESSION["lname"] = $user[0]["lName"];
    $_SESSION["value"] = $user[0]["value"];
    $_SESSION["token"] = $user[0]["mfaToken"];
    $_SESSION["auth"] = false;
    header("Location: ../Pages/mfaCheck.php");
}
else{
    header("Location: ../Pages/index.php?error=login-unsuccessful");
}

