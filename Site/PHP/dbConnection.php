<?php

include_once 'settings.php';
include_once 'AES.php';

function getConnection(){
    $dataSourceName = 'mysql:dbname='.DB_DATABASE.';host='.DB_SERVER;
    $dbConnection = null;
    try
    {
        $dbConnection = new PDO($dataSourceName, DB_USER, DB_PASSWORD);

    }  catch (PDOException $err)
    {
        echo 'Connection failed: ', $err->getMessage();
    }
    return $dbConnection;
}

function createAccount($email, $fname, $lname, $pw, $token) {

    try{
        $sql = sprintf("INSERT INTO users (ID, fName, lName, password, mfaToken) VALUES ('%s', '%s', '%s', '%s', '%s')",
            $email, encrypt($fname), encrypt($lname), encrypt($pw), encrypt($token));
        echo $sql;
        $statement = getConnection()->prepare($sql);
        $statement->execute();
    }
    catch(PDOException $e){
        echo $e->getMessage();

    }

}

function getUser($email) {
    $sql = "SELECT * FROM `users` WHERE ID='".$email."'";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function updateValue($email, $newValue){
    try{
        $sql = sprintf("UPDATE users SET value = '%s' WHERE ID = '%s'", encrypt($email), encrypt(strval($newValue)));
        $statement = getConnection()->prepare($sql);
        $statement->execute();
    }
    catch(PDOException $e){
        echo $e->getMessage();

    }
}

function getDaysChange(){
    $sql = "SELECT * FROM `dayChange`";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


