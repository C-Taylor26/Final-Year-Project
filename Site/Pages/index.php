<?php

session_start();

if (isset($_GET["error"])){
    if ($_GET["error"] = "duplicate-email"){
        echo '<script>alert("Email already in use")</script>';
    }
}
?>

<HTML>
    <HEAD>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Login</title>

        <style>
            .loginBox {
                overflow: hidden;
                background-color: #f1f1f1;
                margin: auto;
                width: 40%;
                border: 3px solid #000000;
                padding: 10px;
                border-bottom: none;
            }

            .loginBox button {
                background-color: inherit;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                margin: auto;
                width: 49%;
            }

            .loginBox button:hover {
                background-color: #ddd;
            }

            .loginBox button.active {
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
        <div class="loginBox" style="margin-top: 10%">
            <button class="tab" onclick="showContent(event, 'login')" id="default">Login</button>
            <button class="tab" onclick="showContent(event, 'register')">Register</button>
        </div>

        <!-- Login Box Tab Contents -->
        <div id="login" class="tabcontent">
            <h1>LOGIN</h1>
            <form>
                <div class="input-group mb-3"><!-- Email Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                    </div>
                    <input type="email" placeholder="someone@email.com" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>

                <div class="input-group mb-3"><!-- Password Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                    </div>
                    <input type="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <button type="button" class="btn btn-warning" style="width:100%">Login</button>
            </form>



        </div>

        <div id="register" class="tabcontent">
            <h1>REGISTER</h1>
            <form action="../PHP/createAccount.php" method="post">
                <div class="input-group mb-3"> <!-- Name Input-->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">First Name</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required name="fname">

                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Last Name</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required name="lname">
                </div>

                <div class="input-group mb-3"><!-- Email Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                    </div>
                    <input type="email" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required name="email">
                </div>

                <div class="input-group mb-3"><!-- Password Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                    </div>
                    <input type="password" id="pass" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required minlength="8" name="pw">
                </div>
                <div style="width: 100%" class="alert alert-warning hidden" id="passwordWarning">
                    Password must be at least 8 characters long, containing Upper and Lowercase Letters and Numbers
                </div>

                <div class="input-group mb-3"><!-- Password Confirm Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Confirm Password</span>
                    </div>
                    <input type="password" id="conPass" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required name="pwCon">
                </div>
                <div class="alert alert-warning" id="passwordVerifyWarning" style="display: none">
                    Sorry, The Passwords Do Not Match
                </div>
                <input type="submit" class="btn btn-warning" style="width:100%" value="Register" id="submitButton">
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


    </script>



    </BODY>
</HTML>

