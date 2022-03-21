<?php
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION["auth"])){
    header("Location: index.php");
}
if (!isset($_SESSION["value"])){
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
        <a class="item" href="monthly-data.php">Monthly Data</a>
        <a class="item" href="index.php?logout=true" style="float: right">Logout</a>
    </div>



    <div id="content">
        <div id="left" style="float: left;width: 70%; padding: 1%;">
            <div id="t-l">
                <!--<h1 id="dateTime"></h1>-->
                <h2 id="change" style="float: right">Change: 50% | $100</h2>
            </div>
            <div id="m-l">
                <!--Chart-->
                <canvas id="mainChart" style="width:100%;"></canvas>
            </div>
        </div>
        <div id="right" style="float: right;width: 30%; padding: 1rem; padding-top: 5rem;">
            <div id="t-r">
                <!--secondary Chart-->
                <h3 style="float: right">Stock Performance</h3>
                <canvas id="secondaryChart" style="width: 100%; float: left"
            </div>
            <div id="m-r">
                <!--secondary Chart options-->
            </div>
            <div id="b-r">
                <!--button to other page-->
                <button type="button" class="btn btn-outline-warning" style="width: 100%">Monthly Data</button>
            </div>
        </div>
    </div>
    <script>
        function timeUpdate() { //Updates Clock every 10000ms to correct time
            let now = new Date()

            let hours = now.getHours().toString()
            if (hours.length === 1) { hours = "0" + hours }

            let minutes = now.getMinutes().toString()
            if (minutes.length === 1) { minutes = "0" + minutes }

            let year = now.getFullYear().toString()

            let month = (now.getMonth()+1).toString()
            if (month.length === 1) { month = "0" + month }

            let day = (now.getDate()).toString()
            if (day.length === 1) { day = "0" + day }

            let time = hours + ":" + minutes
            let date = day + "/" + month + "/" + year

            document.getElementById("dateTime").innerHTML = time + " | " + date
            setTimeout(timeUpdate, 10000)
        }

        function lineChartMain() { //Displays line chart of results
            let xValues = [50,60,70,80,90,100,110,120,130,140,150];
            let yValues = [7,8,8,9,9,9,10,11,14,14,15];

            new Chart("mainChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    scales: {
                        yAxes: [{ticks: {min: 6, max:16}}],
                    }
                }
            });
        }

        function lineChartSide() { //Displays line chart of results
            let xValues = [50,60,70,80,90,100,110,120,130,140,150];
            let yValues = [7,8,8,9,9,9,10,11,14,14,15];

            new Chart("secondaryChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    scales: {
                        yAxes: [{ticks: {min: 6, max:16}}],
                    }
                }
            });
        }

        lineChartSide()
        lineChartMain()
        timeUpdate()


    </script>

</body>


<footer>
    <!--FOOTER-->
</footer>
</HTML>