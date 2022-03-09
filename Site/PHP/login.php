<?php
include_once "dbConnection.php";
if (!isset($_SESSION)){
    session_start();
}

try {
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
                echo "LOGIN";
                $login = true;
            }
        }
    }
    if ($login === true){
        $_SESSION["user"] = $user;
        if ($user[0]["mfaKey"] === ''){
            header("Location: ../Pages/mfaSetup.php");
        }
        else{
            header("Location: ../Pages/overview.php");
        }

    }
    else{
        header("Location: ../Pages/index.php?error=login-unsuccessful");
    }

}
catch (Exception $e){
    echo $e;
}