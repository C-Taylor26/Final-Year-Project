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

function getDaysChange(){
    $sql = "SELECT * FROM `dayChange`";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getLastTrade(){
    $sql = "SELECT `ID` FROM `dayChange`";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function newPosition($value, $ID){
    $x = getLastTrade();
    $startingID = array_pop($x);
    $startingID = $startingID["ID"];

    $d = date("Y-m-d");

    $sql = sprintf("INSERT INTO `userpositions` (userID, openDate, value, startingID) VALUES ('%s', '%s', '%s', '%s')",
                            $ID, encrypt($d), encrypt($value), $startingID);
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    echo $sql;
}

function getTrades($startingID){
    $sql = "SELECT * FROM `dayChange` WHERE ID >" . $startingID;
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    $r = $statement->fetchAll(PDO::FETCH_ASSOC);
    return array_reverse($r);
}

function getUserPositions($ID){
    $sql = "SELECT * FROM `userpositions` WHERE userID='" . $ID."'";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    $r = $statement->fetchAll(PDO::FETCH_ASSOC);
    return array_reverse($r);
}

function closeTrade($tradeID, $closeDate, $change){

    $sql = "UPDATE `userpositions` SET closeDate='".$closeDate."', percentageChange='".$change."' WHERE ID='".$tradeID."'";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
}