<?php

if (!isset($_SESSION)){
    session_start();
}

//Setting up MFA Library
require_once "../../Libraries/vendor/autoload.php";
use RobThree\Auth\TwoFactorAuth;
$tfa = new TwoFactorAuth();


$result = $tfa->verifyCode($_SESSION["token"], $_POST["code"]);

if ($_GET["r"] === "setup"){
    if ($result){
        header("Location: createAccount.php");
    }
    else{
        header("Location: ../Pages/mfaSetup.php?error=codeError");
    }
}
else{
    if ($result){
        $_SESSION["auth"] = true;
        header("Location: ../Pages/overview.php");
        unset($_SESSION["token"]);
    }
    else{
        $_SESSION["auth"] = false;
        header("Location: ../Pages/mfaCheck.php?error=codeError");
    }
}


