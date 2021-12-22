<?php
?>
<HTML>
    <HEAD>
        <link rel="stylesheet" href="style.css">
        <title>Dashboard</title>

    </HEAD>

    <BODY>
    <div id="main">
        <h1>Trader Dashboard</h1>
        <div class="row">
            <div class="column left">
                <h2>Account Value:</h2>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
                <canvas id="myChart" style="width:50%;"></canvas>
                <script>
                    var xValues = [50,60,70,80,90,100,110,120,130,140,150];
                    var yValues = [7,8,8,9,9,9,10,11,14,14,15];

                    new Chart("myChart", {
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
                                yAxes: [{ticks: {min: 1, max:16}}],
                            }
                        }
                    });
                </script>
            </div>
            <div class="column right">
                <div id="changeNumms">
                    <p class="stats">[50% | +$1000]</p>
                </div>
                <div id="pieChart">

                </div>
                <div id="dataButton">

                </div>
            </div>
        </div>
    </div>
    </BODY>
</HTML>

