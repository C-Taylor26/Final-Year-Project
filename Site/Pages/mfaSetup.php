<?php

if (!isset($_SESSION)){
    session_start();
}
var_dump($_SESSION);

//Setting up MFA Library
require_once "../../Libraries/vendor/autoload.php";
use RobThree\Auth\TwoFactorAuth;
$tfa = new TwoFactorAuth();

//Generating Secret
$secret = $tfa->createSecret();

?>

<HTML>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>MFA Setup</title>

    <style>
        .c-r {
            float: right;
            width: 48%;
            padding: 10px;
            text-align: center;
        }
        .c-l {
            float: left;
            width: 48%;
            margin: 10px;
            padding: 10px;
            text-align: center;
        }

        h1 {
            align-content: center;
        }
        .main{

        }
        /*Disabling number input arrows*/
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

</head>

<body>

<div class="main">
    <div id="MFA-Description" class="c-l">
        <h1>MFA</h1>
        <p>MFA or Multi-Factor Authentication is used to ensure an increased level of security for a users account.</p>
        <p>In order to use this service please setup MFA using one of the following applications:</p>
        <p><a href="https://support.google.com/accounts/answer/1066447?hl=en&co=GENIE.Platform%3DAndroid">Google Authenticator</a></p>
        <p><a href="https://www.microsoft.com/en-us/security/mobile-authenticator-app">Microsoft Authenticator</a></p>

    </div>

    <div id="MFA-Code" class="c-r">
        <h1>MFA Code</h1>
        <p>Scan the QR below within your choosen application, or use the 16-digit code</p>
        <img src="<?php echo $tfa->getQRCodeImageAsDataUri("AI Trading", $secret);?>" alt="QR Code">
        <p><?php echo chunk_split($secret,4, " ");?></p>
    </div>
</div>

<div id="verify-Code" class="lower">
    <h1>Verify Code</h1>
    <p>Use the code displayed within your application to verify your identity</p>
    <form action="../PHP/verifyCode?r=setup.php" method="post">
        <input type="text" min="6" maxlength="6" required>
        <button type="submit" class="btn btn-success">Verify</button>
    </form>
</div>

</body>




</HTML>

