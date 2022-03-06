<?php
session_start();
include_once 'dbConnection.php';

try {
    $email = $_POST["email"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];

    $pw = passwordHash($_POST["pw"]);
    $user = getUser($_POST["email"]);

    if (count($user) == 0) {
        createAccount($email, $fname, $lname, $pw);
    }
    else {
        header("Location: ../Pages/index.php?error=duplicate-email");
    }
}

catch (Exception $e){
    echo $e;
}


function passwordHash($pwIn){
    #Adding Password Salt
    $pwIn = "i%l]C;H" . $pwIn;

    #Adding Password Pepper
    $pwIn .= randomCharacter();

    #Hashing Salted and Peppered Password
    return strtoupper(hash("sha256" ,$pwIn));
}

function randomCharacter() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $characters[rand(0, strlen($characters) - 1)];
}




