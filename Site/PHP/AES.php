<?php

include_once "settings.php";

function encrypt($plainText){
    return openssl_encrypt($plainText, CIPHER, KEY, $options = 0, IV);
}

function decrypt($cipherText){
    return openssl_decrypt($cipherText, CIPHER, KEY, $options = 0, IV);
}