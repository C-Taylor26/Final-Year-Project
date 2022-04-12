<?php
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION["auth"])){
    header("Location: index.php");
}
else if ($_SESSION["auth"] === false){
    header("Location: mfaCheck.php?error=authRequired");
}
var_dump($_SESSION);
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
        <h1>***Place Holder Table</h1>
        <div style="border: #333333 solid">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="column-right">
        <div class="justify-content-center">
            <div style="text-align: center; margin-bottom: 5%;">
                <h1>Account Information</h1>
                <h2><?php echo $_SESSION["fname"], " ", $_SESSION["lname"], "    -    Equity: \$XXX"?></h2>
            </div>
            <div style="padding: 10px; border: #333333 solid; text-align: center; align-content: center; margin: auto">
                <button type="button" class="btn btn-success" style="width: 90%; margin: 1%">Deposit</button>

            </div>
        </div>
    </div>

</div>

</body>


<footer>
    <!--FOOTER-->
</footer>
</HTML>