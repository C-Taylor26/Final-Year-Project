<?php
include_once "dbConnection.php";


try {
    $email = $_POST["email"];
    $pw = $_POST["pw"];

    $saltedPW = SALT . $pw;

    $user = getUser($email);

    if (count($user)>0){
        $userPass = $user[0]
    }

    for ($i=0; $i < 26; $i++){

    }
}
catch (Exception $e){
    echo $e;
}