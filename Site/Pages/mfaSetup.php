<?php
require_once "../../Libraries/vendor/autoload.php";

if (!isset($_SESSION)){
    session_start();
}

//Setting up MFA Library
use RobThree\Auth\TwoFactorAuth;
$tfa = new TwoFactorAuth();

if (!isset($_SESSION["email"])){
    header("Location: index.php");
}
if (!isset($_SESSION["token"])){
    $_SESSION["token"] = $tfa->createSecret();
}


//Showing Error message if required
if(isset($_GET["error"])){
    echo "<script>window.addEventListener('load', (event) => {showError();});</script>";
}

var_dump($_SESSION);
?>

<HTML>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>MFA Setup</title>

    <style>
        .c-r {
            float: right;
            width: 50%;
            padding: 10px;
            text-align: center;
        }
        .c-l {
            float: left;
            width: 50%;
            padding: 10px;
            text-align: center;
        }

        .main{
            width: 100%;
            padding: 2.5%;
            text-align: center;
        }
        .lower{
            width: 20%;
            margin: auto;
            align-content: center;
            text-align: center;
        }
    </style>

</head>

<body>

<div class="row">
    <div id="MFA-Description" class="c-l">
        <h1>MFA</h1>
        <p>MFA or Multi-Factor Authentication is used to ensure an increased level of security for a users account.</p>
        <p>In order to use this service please setup MFA using one of the following applications:</p>
        <p><a href="https://support.google.com/accounts/answer/1066447?hl=en&co=GENIE.Platform%3DAndroid" target="_blank">Google Authenticator</a></p>
        <p><a href="https://www.microsoft.com/en-us/security/mobile-authenticator-app" target="_blank">Microsoft Authenticator</a></p>

    </div>

    <div id="MFA-Code" class="c-r">
        <h1>MFA Code</h1>
        <p>Scan the QR below within your choosen application, or use the 16-digit code</p>
        <img src="<?php echo $tfa->getQRCodeImageAsDataUri("AI Trading", $_SESSION["token"]);?>" alt="QR Code">
        <p><?php echo chunk_split($_SESSION["token"],4, " ");?></p>
    </div>

</div>
<div class="row">
    <div id="verify-Code" class="lower">
        <h1>Verify Code</h1>
        <p>Use the code displayed within your application to verify your identity</p>
        <form action="../PHP/verifyCode.php?r=setup" method="post">
            <input type="text" min="6" maxlength="6" required name="code">
            <div class="alert alert-danger" id="codeError" style="display: none;">
                Incorrect Code
            </div>
            <button type="submit" class="btn btn-success">Verify</button>
        </form>
    </div>
</div>

<script>
    function showError() {
        let errormsg = document.getElementById("codeError");
        errormsg.style.display = "block";
    }
</script>

</body>




</HTML>

