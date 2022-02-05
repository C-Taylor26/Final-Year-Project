<HTML>


<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- JS Charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<head>
    <title>Dashboard</title>
    <!-- BANNER -->
</head>

<body>
    <div id="left">
        <div id="t-l">
            <h1 id="dateTime"></h1>
        </div>
        <div id="m-l">
            <!--Chart-->
            <canvas id="mainChart" style="width:100%;"></canvas>
        </div>
    </div>
    <div id="middle">
        <div id="t-m">
            <!--Change %/$-->
        </div>
        <div id="m-m">
            <!--chart options-->
        </div>
        <div id="b-m">

        </div>
    </div>
    <div id="right">
        <div id="t-r">
            <!--secondary Chart-->
        </div>
        <div id="m-r">
            <!--secondary Chart options-->
        </div>
        <div id="b-r">
            <!--button to other page-->
            <button type="button" class="btn btn-outline-warning" style="width: 90%">Monthly Data</button>
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

            let day = (now.getDay()-1).toString()
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

        lineChartMain()
        timeUpdate()


    </script>

</body>


<footer>
    <!--FOOTER-->
</footer>
</HTML>