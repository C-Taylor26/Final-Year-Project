<?php

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$pw = $_POST["pw"];

$hashedPW = password($pw);

function password($pwIn){
   #Adding Password Salt
    $pw = "i%l]C;H" . $pwIn;

    #Adding Password Pepper
    $pw .= randomCharacter();

    #Hashing Salted and Peppered Password
    return hash("sha256" ,$pw);
}

function randomCharacter() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $characters[rand(0, strlen($characters) - 1)];
}