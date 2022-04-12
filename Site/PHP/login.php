<?php
include_once "dbConnection.php";
include_once "settings.php";
include_once 'AES.php';

if (!isset($_SESSION)){
    session_start();
}

$email = hash("sha256", $_POST["email"]);
$pw = $_POST["pw"];

$saltedPW = SALT . $pw;

$user = getUser($email);
$login = false;
if (count($user)>0) {
    $pwActual = decrypt($user[0]["password"]);

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
    $_SESSION["fname"] = decrypt($user[0]["fName"]);
    $_SESSION["lname"] = decrypt($user[0]["lName"]);
    $_SESSION["token"] = decrypt($user[0]["mfaToken"]);
    $_SESSION["auth"] = false;
    header("Location: ../Pages/mfaCheck.php");
}
else{
    header("Location: ../Pages/index.php?error=login-unsuccessful");
}

