<?php
?>
<HTML>
    <HEAD>
        <title>Login</title>

        <style>
            .loginBox {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
            }
            .loginBox button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
            }

            .loginBox button:hover {
                background-color: #ddd;
            }

            .loginBox button.active {
                background-color: #ccc;
            }

            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }


        </style>



    </HEAD>

    <BODY>
    <div id="main">
        <div class="loginBox">
            <button class="tab" onclick="showContent(event, 'login')" id="default">Login</button>
            <button class="tab" onclick="showContent(event, 'register')">Register</button>
        </div>
        <!-- Login Box Tab Contents -->
        <div id="login" class="tabcontent">
            <h1>LOGIN</h1>



        </div>

        <div id="register" class="tabcontent">
            <h1>REGISTER</h1>




        </div>
    </div>

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

