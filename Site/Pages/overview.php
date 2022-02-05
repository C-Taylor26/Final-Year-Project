<HTML>
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

        timeUpdate()
    </script>

</body>


<footer>
    <!--FOOTER-->
</footer>
</HTML>