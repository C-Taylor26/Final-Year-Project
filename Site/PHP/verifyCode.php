<?php

if (!isset($_SESSION)){
    session_start();
}
var_dump($_SESSION);

//Setting up MFA Library
require_once "../../Libraries/vendor/autoload.php";
use RobThree\Auth\TwoFactorAuth;
$tfa = new TwoFactorAuth();


$result = $tfa->verifyCode($_POST["token"], $_POST["code"]);
if ($result){
    header("Location: ../Pages/index.php");
}
else{
    if ($_GET["r"] === "setup"){
        header("Location: ../Pages/mfaSetup.php?error=incorrectCode");
    }
    else{
        header("Location: ../Pages/OTHER-MFA.php?error=incorrectCode");
    }
}
