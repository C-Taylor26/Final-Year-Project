<?php
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION["value"])){
    header("Location: index.php");
}
else if ($_SESSION["auth"] === false){
    header("Location: mfaCheck.php?error=authRequired");
}
?>
<HTML>
    <HEAD>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Account</title>

        <style>
            .optionBox {
                overflow: hidden;
                background-color: #f1f1f1;
                margin: auto;
                width: 40%;
                border: 3px solid #000000;
                padding: 10px;
                border-bottom: none;
            }

            .optionBox button {
                background-color: inherit;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                margin: auto;
                width: 49%;
            }

            .optionBox button:hover {
                background-color: #ddd;
            }

            .optionBox button.active {
                background-color: #ccc;
            }

            .tabcontent {
                display: none;
                padding: 6px 10px;
                border: 3px solid #000000;
                border-top: none;
                margin: auto;
                width: 40%;
                text-align: center;
            }
        </style>

    </HEAD>

    <BODY>
    <div id="main">
        <div class="alert alert-danger" id="500" style="display: none; text-align: center;">
            An unexpected error occurred
        </div>
        <div class="optionBox" style="margin-top: 10%">
            <button class="tab" onclick="showContent(event, 'deposit')" id="default">Deposit Funds</button>
            <button class="tab" onclick="showContent(event, 'withdraw')" id = "secondary">Withdraw Funds</button>
        </div>

        <!-- Deposit Box Tab Contents -->
        <div id="deposit" class="tabcontent">
            <h1>Deposit</h1>
            <form action="../PHP/valueChange.php?action=deposit" method="post">
                <div class="alert alert-danger" id="error-alert" style="display: none">
                    There was a problem processing your request, please try again.
                </div>
                <div class="input-group mb-3"><!--Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Amount ($)</span>
                    </div>
                    <input type="number" placeholder="" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required name="amount">
                </div>
                <button type="submit" class="btn btn-warning" style="width:100%">Deposit</button>
            </form>
        </div>

        <!-- Withdraw Box Tab Contents -->
        <div id="withdraw" class="tabcontent">
            <h1>Withdraw</h1>
            <form>

            </form>
        </div>
    </div>

    <script src="../JavaScript/passwordCheck.js"></script>
    <script>
        function showContent(event, option) {
            // Declare all variables
            var i, tabcontent, tab;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tabs = document.getElementsByClassName("tab");
            for (i = 0; i < tabs.length; i++) {
                tabs[i].className = tabs[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(option).style.display = "block";
            event.currentTarget.className += " active";
        }

        document.getElementById("default").click();

        function showError(){
            let errormsg = document.getElementById("500");
            errormsg.style.display = "block";
        }

    </script>

    <?php
    ?><script type="text/javascript">document.getElementById("duplicate-email").style.display = "none";</script><?php
    ?><script type="text/javascript">document.getElementById("login-alert").style.display = "none";</script><?php
    if (isset($_GET["error"])){
        if ($_GET["error"] === "duplicate-email"){
            ?><script type="text/javascript">document.getElementById("duplicate-email").style.display = "block";document.getElementById("secondary").click();</script><?php
        }
        if ($_GET["error"] === "login-unsuccessful"){
            ?><script type="text/javascript">document.getElementById("login-alert").style.display = "block";</script><?php
        }
    }
    ?>


    </BODY>

</HTML>
