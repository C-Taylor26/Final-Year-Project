<?php

//const xmlhttp = new XMLHttpRequest();

include_once "../PHP/dbConnection.php";

if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION["auth"])){
    header("Location: index.php");
}
else if ($_SESSION["auth"] === false){
    header("Location: mfaCheck.php?error=authRequired");
}

if (isset($_GET["limit"])){
    $limit = $_GET["limit"];
}
else{
    $limit = 9999;
}
$chartData = getDaysChange();
$charDataJson = json_encode($chartData);

?>

<HTML>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- JS Charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<head>
    <title>Dashboard</title>

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

    </style>

</head>

<body>
    <div class="nav-bar">
        <a class="banner-title">AI Stock Trader</a>
        <a class="item" href="overview.php">Dashboard</a>
        <a class="item" href="account.php">My Account</a>
        <a class="item" href="index.php?logout=true" style="float: right">Logout</a>
    </div>



    <div id="content">
        <div class="row" style="padding-left: 20px";>
            <h1>AI Trading Performance</h1>
        </div>
        <div id="left" style="float: left;width: 80%; padding: 1%;">
            <div id="t-l">
                <!--<h1 id="dateTime"></h1>-->
                <h2 id="change" style="float: right">Change: 50%</h2>
            </div>
            <div id="m-l">
                <!--Chart-->
                <canvas id="mainChart" style="width:100%;"></canvas>
            </div>
        </div>
        <div id="right" style="float: right;width: 20%; padding: 1rem; padding-top: 5rem;">
            <div id="t-r">
                <form action="overview.php" method="get">
                    <p>Timeframe:</p>
                    <input type="radio" id="r" name="limit" value="7">
                    <label for="r">Past Week</label><br>
                    <input type="radio" id="r1" name="limit" value="30">
                    <label for="r1">30 Days</label><br>
                    <input type="radio" id="r2" name="limit" value="60">
                    <label for="r2">60 Days</label><br>
                    <input type="radio" id="r3" name="limit" value="9999">
                    <label for="r3">All Time</label><br><br>
                    <input type="submit" value="update" class="btn btn-outline-primary" style="width: 20%">
                </form>
            </div>
        </div>
    </div>
    <script>

        function lineChartMain() { //Displays line chart of results
            let chartDataText = '<?php echo $charDataJson?>'
            let chartData = JSON.parse(chartDataText)

            let limit = parseInt('<?php echo $limit?>')
            if (limit > chartData.length-1){
                limit = chartData.length-1
            }

            let xValues = []; //Bottom of chart
            let yValues = []; //data in chart
            let yMin = 0; //bottom Y axis label
            let yMax = 0; //top Y axis label
            let totalChange = 0;

            for (let i = limit; i>-1; i--){
                xValues.push(chartData[i].date);
                totalChange = totalChange + parseFloat(chartData[i].percentageChange);
                yValues.push(totalChange)

                if (totalChange > yMax) {
                    yMax = totalChange;
                }
                if (totalChange < yMin){
                    yMin = totalChange;
                }
            }

            document.getElementById("change").innerHTML = "Change: " + (totalChange*100).toFixed(2) + "%";

            for (let i = 0; i<yValues.length; i++){
                yValues[i] = yValues[i] * 100
            }

            yMin = yMin * 100;
            yMax = yMax * 100;

            new Chart("mainChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgb(0,34,255)",
                        borderColor: "rgb(110,131,245)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    scales: {
                        yAxes: [{ticks: {min: yMin, max:yMax}}],
                    }
                }
            });
        }


        lineChartMain()


    </script>

</body>


<footer>
    <!--FOOTER-->
</footer>
</HTML>