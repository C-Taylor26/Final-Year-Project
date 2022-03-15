<?php
include_once "settings.php";

function hashPassword($pwIn){
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