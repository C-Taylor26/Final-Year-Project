<?php

include_once "../PHP/dbConnection.php";
include_once "../PHP/AES.php";

if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION["auth"])){
    header("Location: index.php");
}
else if ($_SESSION["auth"] === false){
    header("Location: mfaCheck.php?error=authRequired");
}

?>

<HTML>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<head>
    <title>Account</title>

    <style>
        .nav-bar {
            overflow: hidden;
            background-color: #333;
        }

        .nav-bar a.item {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .nav-bar a.item:hover {
            background-color: #ddd;
            color: black;
        }

        .nav-bar a.active {
            background-color: #04AA6D;
            color: white;
        }
        .banner-title {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            background-color: #04AA6D;
        }
        .column-left {
            width: 65%;
            padding: 10px;
            float: left;
        }
        .column-right {
            width: 35%;
            padding: 10px;
            float: right;
        }
    </style>

</head>

<body>
<div class="nav-bar">
    <a class="banner-title">AI Stock Trader</a>
    <a class="item" href="overview.php">Dashboard</a>
    <a class="item" href="monthly-data.php">Monthly Data</a>
    <a class="item" href="index.php?logout=true" style="float: right">Logout</a>
</div>
<div>
    <div class="column-left">
        <h1>Positions</h1>
        <div style="border: #333333 solid">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Open Date</th>
                    <th scope="col">Close Date</th>
                    <th scope="col">Starting Value</th>
                    <th scope="col">Change</th>
                    <th scope="col">Current Value</th>
                    <th scope="col">Close Trade</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $positions = getUserPositions($_SESSION["email"]);
                $totalEquity = 0;

                foreach ($positions as $p){
                    $openDate = decrypt($p["openDate"]);
                    $closeDate = decrypt($p["closeDate"]);

                    $startingValue = floatval(decrypt($p["value"]));
                    $change = 0;
                    if ($closeDate == ""){
                        $closeDate = "-";

                        $days = getTrades($p["startingID"]);
                        foreach ($days as $day){
                            $change = $change + floatval($day["percentageChange"]);
                        }
                        $btn = '<a href="../PHP/closeTrade.php?tradeID='.$p["ID"]. '&change='.$change.'&startingValue='.$startingValue.'" class="btn btn-primary" role="button">Close Trade</a>';
                        $totalEquity = $totalEquity + (($change+1) * $startingValue);
                    }
                    else{
                        $btn = "Trade Closed";
                        $change = floatval(decrypt($p["percentageChange"]));
                    }

                    $currentValue = ($change+1) * $startingValue;
                    $change = $change *100;

                    $currentValue  = number_format($currentValue, 2, '.', ',');
                    $change = number_format($change, 2, '.', ',');
                    $startingValue = number_format($startingValue, 2, '.', ',');



                    echo '<tr>
                            <td>' . $openDate .'</td>
                            <td>' . $closeDate .'</td>
                            <td>£' . $startingValue .'</td>
                            <td>' . $change .'</td>
                            <td>£' . $currentValue . '</td>
                            <td>' . $btn . '</td>
                          </tr>';
                }

                $totalEquity = number_format($totalEquity, 2, '.', ',');
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="column-right">
        <div class="justify-content-center">
            <div style="text-align: center; margin-bottom: 5%;">
                <h1>Account Information</h1>
                <h2><?php echo $_SESSION["fname"], " ", $_SESSION["lname"], "    -    Equity: £$totalEquity"?></h2>
            </div>
            <div style="padding: 10px; border: #333333 solid; text-align: center; align-content: center; margin: auto">
                <!--<button type="button" class="btn btn-success" style="width: 90%; margin: 1%">Deposit</button>-->
                <a href="deposit.php?" class="btn btn-success" role="button" style="width: 90%; margin: 1%">Deposit</a>
            </div>
        </div>
    </div>

</div>

</body>


<footer>
    <!--FOOTER-->
</footer>
</HTML>