<?php
if (!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION["token"])){
    header("Location: index.php?error=500");
}

//Showing Error message if required
if(isset($_GET["error"])){
    echo "<script>window.addEventListener('load', (event) => {showError();});</script>";
}

?>

<HTML>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>MFA Check</title>

    <style>
        #codeCheck {
            overflow: hidden;
            background-color: #f1f1f1;
            margin: auto;
            width: 40%;
            border: 3px solid #000000;
            padding: 10px;
            align-content: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="codeCheck" style="margin-top: 10%">
        <h1>MFA Check</h1>
        <p>Enter code show on your chosen authenticator application:</p>

        <form action="../PHP/verifyCode.php?r=login" method="post">
            <div style="width: 100%; padding: 1%">
                <input type="text" min="6" maxlength="6" required name="code" style="width: 30%">
            </div>

            <div class="alert alert-danger" id="codeError" style="display: none;">
                Incorrect Code
            </div>
            <button type="submit" class="btn btn-success" style="width: 30%">Verify</button>
        </form>
    </div>

    <script>
        function showError() {
            let errormsg = document.getElementById("codeError");
            errormsg.style.display = "block";
        }
    </script>
</body>
</HTML>
