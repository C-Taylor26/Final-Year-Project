<?php
if (!isset($_SESSION)){
    session_start();
}

include_once 'dbConnection.php';

try {
    $email = $_POST["email"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $secret = $_POST["token"];

    $pw = passwordHash($_POST["pw"]);
    $user = getUser($_POST["email"]);

    if (count($user) == 0) {
        createAccount($email, $fname, $lname, $pw, $secret);
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
    $pwIn = SALT . $pwIn;

    #Adding Password Pepper
    $pwIn .= randomCharacter();

    #Hashing Salted and Peppered Password
    return strtoupper(hash("sha256" ,$pwIn));
}

function randomCharacter() {
    return PEPPER_CHARS[rand(0, strlen(PEPPER_CHARS) - 1)];
}




